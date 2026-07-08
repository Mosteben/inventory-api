<?php

namespace App\Repositories;

use App\Contracts\SupplierRepositoryInterface;
use App\Factories\SupplierFactory;
use App\Models\Supplier;

class SupplierRepository
    extends BaseRepository
    implements SupplierRepositoryInterface
{
    public function getAll(): array
    {
        $stmt = $this->conn->query("
            SELECT *
            FROM suppliers
            ORDER BY id DESC
        ");

        $rows = $stmt->fetchAll(
            \PDO::FETCH_ASSOC
        );

        $suppliers = [];

        foreach ($rows as $row) {

            $suppliers[] =
                SupplierFactory::create(
                    $row
                );
        }

        return $suppliers;
    }

    public function getById(
        int $id
    ): ?Supplier
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM suppliers
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

        return SupplierFactory::create(
            $row
        );
    }

    public function create(
        Supplier $supplier
    ): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO suppliers
            (
                name,
                email,
                phone,
                address
            )
            VALUES
            (
                :name,
                :email,
                :phone,
                :address
            )
        ");

        $stmt->execute([
            ':name' => $supplier->getName(),
            ':email' => $supplier->getEmail(),
            ':phone' => $supplier->getPhone(),
            ':address' => $supplier->getAddress()
        ]);

        return (int)
            $this->conn->lastInsertId();
    }

    public function update(
        int $id,
        Supplier $supplier
    ): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE suppliers
            SET
                name = :name,
                email = :email,
                phone = :phone,
                address = :address
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id,
            ':name' => $supplier->getName(),
            ':email' => $supplier->getEmail(),
            ':phone' => $supplier->getPhone(),
            ':address' => $supplier->getAddress()
        ]);
    }

    public function hasProducts(
        int $id
    ): bool
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*)
            FROM products
            WHERE supplier_id = :id
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
            FROM suppliers
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}