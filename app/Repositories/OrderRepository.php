<?php

namespace App\Repositories;

use App\Factories\OrderFactory;
use App\Factories\OrderItemFactory;
use App\Models\Order;

class OrderRepository extends BaseRepository
{
    public function getAll(): array
    {
        $stmt = $this->conn->query("
            SELECT *
            FROM orders
            ORDER BY id DESC
        ");

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $orders = [];

        foreach ($rows as $row) {
            $orders[] = $this->getById((int)$row['id']);
        }

        return $orders;
    }

    public function getById(int $id): ?Order
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM orders
            WHERE id = :id
        ");

        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $order = OrderFactory::createFromDatabase($row);

        $itemsStmt = $this->conn->prepare("
            SELECT
                oi.id,
                oi.order_id,
                oi.quantity AS order_quantity,
                oi.price,

                p.id AS product_id,
                p.name,
                p.description,
                p.sku,
                p.price AS product_price,
                p.quantity,
                p.status,

                c.id AS category_id,
                c.name AS category_name,

                s.id AS supplier_id,
                s.name AS supplier_name

            FROM order_items oi

            INNER JOIN products p ON p.id = oi.product_id
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN suppliers s ON s.id = p.supplier_id

            WHERE oi.order_id = :order_id
        ");

        $itemsStmt->execute([':order_id' => $id]);

        $items = [];

        while ($row = $itemsStmt->fetch(\PDO::FETCH_ASSOC)) {
            $items[] = OrderItemFactory::createFromDatabase($row);
        }

        $order->setItems($items);

        return $order;
    }

    public function create(array $data): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO orders (user_id, total, status)
            VALUES (:user_id, :total, :status)
        ");

        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':total' => $data['total'],
            ':status' => $data['status']
        ]);

        return (int)$this->conn->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE orders
            SET status = :status
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id,
            ':status' => $data['status']
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("
            DELETE FROM orders
            WHERE id = :id
        ");

        return $stmt->execute([':id' => $id]);
    }

    public function createOrderItem(array $item): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO order_items
            (order_id, product_id, quantity, price)
            VALUES
            (:order_id, :product_id, :quantity, :price)
        ");

        $stmt->execute([
            ':order_id' => $item['order_id'],
            ':product_id' => $item['product_id'],
            ':quantity' => $item['quantity'],
            ':price' => $item['price']
        ]);

        return (int)$this->conn->lastInsertId();
    }

    public function getOrderItems(int $orderId): array
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM order_items
            WHERE order_id = :order_id
        ");

        $stmt->execute([':order_id' => $orderId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

