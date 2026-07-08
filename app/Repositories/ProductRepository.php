<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Factories\ProductFactory;
use App\Models\Product;

class ProductRepository
    extends BaseRepository
    implements ProductRepositoryInterface
{
   public function getAll(
    array $filters = []
): array
{
    $sql = "
        SELECT
            p.*,
            c.name AS category_name,
            s.name AS supplier_name
        FROM products p
        LEFT JOIN categories c
            ON p.category_id = c.id
        LEFT JOIN suppliers s
            ON p.supplier_id = s.id
        WHERE 1 = 1
    ";

    $params = [];

    $this->applyFilters(
        $sql,
        $params,
        $filters
    );

    $this->applySorting(
        $sql,
        $filters
    );

    $page = max(
        1,
        (int)($filters['page'] ?? 1)
    );

    $limit = max(
        1,
        (int)($filters['limit'] ?? 10)
    );

    $offset =
        ($page - 1) * $limit;

    $sql .= "
        LIMIT :limit
        OFFSET :offset
    ";

    $stmt =
        $this->conn->prepare(
            $sql
        );

    foreach ($params as $key => $value) {

        $stmt->bindValue(
            $key,
            $value
        );
    }

    $stmt->bindValue(
        ':limit',
        $limit,
        \PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':offset',
        $offset,
        \PDO::PARAM_INT
    );

    $stmt->execute();

    $rows =
        $stmt->fetchAll(
            \PDO::FETCH_ASSOC
        );

    $products = [];

    foreach ($rows as $row) {

        $products[] =
            ProductFactory::create(
                $row
            );
    }

    $total =
    $this->getTotalProducts(
        $filters
    );

return [

    'data' => $products,

    'pagination' => [

        'page' => $page,

        'limit' => $limit,

        'total' => $total,

        'last_page' =>
            (int)ceil(
                $total / $limit
            )
    ]
];
}

private function applyFilters(
    string &$sql,
    array &$params,
    array $filters
): void
{
    if (!empty($filters['q'])) {

        $sql .= "
            AND
            (
                p.name LIKE :keyword
                OR
                p.sku LIKE :keyword
            )
        ";

        $params[':keyword'] =
            '%' .
            trim($filters['q']) .
            '%';
    }

    if (!empty($filters['category'])) {

        $sql .= "
            AND
            p.category_id = :category
        ";

        $params[':category'] =
            (int)$filters['category'];
    }

    if (!empty($filters['supplier'])) {

        $sql .= "
            AND
            p.supplier_id = :supplier
        ";

        $params[':supplier'] =
            (int)$filters['supplier'];
    }

    if (
        isset($filters['low_stock']) &&
        $filters['low_stock'] === 'true'
    ) {

        $sql .= "
            AND
            p.quantity <= :low_stock
        ";

        $params[':low_stock'] = 5;
    }
}
private function applySorting(
    string &$sql,
    array $filters
): void
{
    $allowedSorts = [
        'id',
        'name',
        'price',
        'quantity',
        'sku'
    ];

    $sort =
        $filters['sort']
        ?? 'id';

    $order =
        strtoupper(
            $filters['order']
            ?? 'DESC'
        );

    if (
        !in_array(
            $sort,
            $allowedSorts,
            true
        )
    ) {

        $sort = 'id';
    }

    if (
        !in_array(
            $order,
            ['ASC', 'DESC'],
            true
        )
    ) {

        $order = 'DESC';
    }

    $sql .= "
        ORDER BY
        p.$sort
        $order
    ";
}
    public function getById(
        int $id
    ): ?Product
    {
        $stmt = $this->conn->prepare("
            SELECT
                p.*,
                c.name AS category_name,
                s.name AS supplier_name
            FROM products p
            LEFT JOIN categories c
                ON p.category_id = c.id
            LEFT JOIN suppliers s
                ON p.supplier_id = s.id
            WHERE p.id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        $row = $stmt->fetch(
            \PDO::FETCH_ASSOC
        );

        if (!$row) {
            return null;
        }

        return ProductFactory::create(
            $row
        );
    }

    public function create(
        Product $product
    ): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO products
            (
                name,
                description,
                sku,
                price,
                quantity,
                category_id,
                supplier_id
            )
            VALUES
            (
                :name,
                :description,
                :sku,
                :price,
                :quantity,
                :category_id,
                :supplier_id
            )
        ");

        $stmt->execute([
            ':name' => $product->getName(),
            ':description' => $product->getDescription(),
            ':sku' => $product->getSku(),
            ':price' => $product->getPrice(),
            ':quantity' => $product->getQuantity(),
            ':category_id' => $product->getCategory()?->getId(),
            ':supplier_id' => $product->getSupplier()?->getId()
        ]);

        return (int) $this->conn->lastInsertId();
    }

    public function update(
        int $id,
        Product $product
    ): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE products
            SET
                name = :name,
                description = :description,
                sku = :sku,
                price = :price,
                quantity = :quantity,
                category_id = :category_id,
                supplier_id = :supplier_id
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id,
            ':name' => $product->getName(),
            ':description' => $product->getDescription(),
            ':sku' => $product->getSku(),
            ':price' => $product->getPrice(),
            ':quantity' => $product->getQuantity(),
            ':category_id' => $product->getCategory()?->getId(),
            ':supplier_id' => $product->getSupplier()?->getId()
        ]);
    }

    public function delete(
        int $id
    ): bool
    {
        $stmt = $this->conn->prepare("
            DELETE
            FROM products
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function updateQuantity(
        int $productId,
        int $quantity
    ): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE products
            SET quantity = :quantity
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $productId,
            ':quantity' => $quantity
        ]);
    }

    public function restoreStock(
        int $productId,
        int $quantity
    ): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE products
            SET quantity = quantity + :quantity
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $productId,
            ':quantity' => $quantity
        ]);
    }

    public function reduceStock(
        int $productId,
        int $quantity
    ): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE products
            SET quantity = quantity - :quantity
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $productId,
            ':quantity' => $quantity
        ]);
    }
    public function getLowStock(
    int $limit = 5
): array
{
    $stmt = $this->conn->prepare("
        SELECT
            p.*,
            c.name AS category_name,
            s.name AS supplier_name
        FROM products p
        LEFT JOIN categories c
            ON p.category_id = c.id
        LEFT JOIN suppliers s
            ON p.supplier_id = s.id
        WHERE p.quantity <= :limit
        ORDER BY p.quantity ASC
    ");

    $stmt->bindValue(
        ':limit',
        $limit,
        \PDO::PARAM_INT
    );

    $stmt->execute();

    $rows = $stmt->fetchAll(
        \PDO::FETCH_ASSOC
    );

    $products = [];

    foreach ($rows as $row) {

        $products[] =
            ProductFactory::create(
                $row
            );
    }

    return $products;
}
public function search(
    string $keyword
): array
{
    $stmt = $this->conn->prepare("
        SELECT
            p.*,
            c.name AS category_name,
            s.name AS supplier_name
        FROM products p
        LEFT JOIN categories c
            ON p.category_id = c.id
        LEFT JOIN suppliers s
            ON p.supplier_id = s.id
        WHERE
            p.name LIKE :keyword
            OR
            p.sku LIKE :keyword
        ORDER BY p.name ASC
    ");

    $stmt->execute([

        ':keyword' => "%{$keyword}%"

    ]);

    $rows = $stmt->fetchAll(
        \PDO::FETCH_ASSOC
    );

    $products = [];

    foreach ($rows as $row) {

        $products[] =
            ProductFactory::create(
                $row
            );
    }

    return $products;
}
private function getTotalProducts(
    array $filters
): int
{
    $sql = "
        SELECT COUNT(*)
        FROM products p
        WHERE 1 = 1
    ";

    $params = [];

    if (!empty($filters['q'])) {

        $sql .= "
            AND
            (
                p.name LIKE :keyword
                OR
                p.sku LIKE :keyword
            )
        ";

        $params[':keyword'] =
            '%' .
            trim($filters['q']) .
            '%';
    }

    if (!empty($filters['category'])) {

        $sql .= "
            AND
            p.category_id = :category
        ";

        $params[':category'] =
            (int)$filters['category'];
    }

    if (!empty($filters['supplier'])) {

        $sql .= "
            AND
            p.supplier_id = :supplier
        ";

        $params[':supplier'] =
            (int)$filters['supplier'];
    }

    if (
        isset($filters['low_stock']) &&
        $filters['low_stock'] === 'true'
    ) {

        $sql .= "
            AND
            p.quantity <= :low_stock
        ";

        $params[':low_stock'] = 5;
    }

    $stmt =
        $this->conn->prepare($sql);

    $stmt->execute($params);

    return (int)$stmt->fetchColumn();
}
public function increaseStock(
    int $productId,
    int $quantity
): bool
{
    $stmt = $this->conn->prepare("
        UPDATE products
        SET quantity = quantity + :quantity
        WHERE id = :id
    ");

    return $stmt->execute([
        ':id' => $productId,
        ':quantity' => $quantity
    ]);
}
}