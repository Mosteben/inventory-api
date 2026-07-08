<?php

namespace App\Repositories;

use App\Contracts\CategoryRepositoryInterface;
use App\Factories\CategoryFactory;
use App\Models\Category;

class CategoryRepository
    extends BaseRepository
    implements CategoryRepositoryInterface
{
    public function getAll(): array
    {
        $stmt = $this->conn->query("
            SELECT *
            FROM categories
            ORDER BY id DESC
        ");

        $rows = $stmt->fetchAll(
            \PDO::FETCH_ASSOC
        );

        $categories = [];

        foreach ($rows as $row) {

            $categories[] =
                CategoryFactory::create(
                    $row
                );
        }

        return $categories;
    }

    public function getById(
        int $id
    ): ?Category
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM categories
            WHERE id = :id
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

        return CategoryFactory::create(
            $row
        );
    }

    public function create(
        Category $category
    ): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO categories
            (
                name,
                description
            )
            VALUES
            (
                :name,
                :description
            )
        ");

        $stmt->execute([
            ':name' =>
                $category->getName(),

            ':description' =>
                $category->getDescription()
        ]);

        return (int)
            $this->conn->lastInsertId();
    }

    public function update(
        int $id,
        Category $category
    ): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE categories
            SET
                name = :name,
                description = :description
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id,

            ':name' =>
                $category->getName(),

            ':description' =>
                $category->getDescription()
        ]);
    }

    public function hasProducts(
        int $id
    ): bool
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*)
            FROM products
            WHERE category_id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function delete(
        int $id
    ): bool
    {
        $stmt = $this->conn->prepare("
            DELETE
            FROM categories
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}