<?php

namespace App\Repositories;

use App\Contracts\InventoryTransactionRepositoryInterface;
use App\Factories\InventoryTransactionFactory;
use App\Models\InventoryTransaction;

class InventoryTransactionRepository
    extends BaseRepository
    implements InventoryTransactionRepositoryInterface
{
    public function create(
        InventoryTransaction $transaction
    ): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO inventory_transactions
            (
                product_id,
                user_id,
                type,
                quantity,
                note
            )
            VALUES
            (
                :product_id,
                :user_id,
                :type,
                :quantity,
                :note
            )
        ");

        $stmt->execute([
            ':product_id' => $transaction->getProductId(),
            ':user_id'    => $transaction->getUserId(),
            ':type'       => $transaction->getType(),
            ':quantity'   => $transaction->getQuantity(),
            ':note'       => $transaction->getNote()
        ]);

        return (int)$this->conn->lastInsertId();
    }

    public function getByProductId(
        int $productId
    ): array
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM inventory_transactions
            WHERE product_id = :product_id
            ORDER BY created_at DESC
        ");

        $stmt->execute([
            ':product_id' => $productId
        ]);

        $rows = $stmt->fetchAll(
            \PDO::FETCH_ASSOC
        );

        $transactions = [];

        foreach ($rows as $row) {

            $transactions[] =
                InventoryTransactionFactory::create(
                    $row
                );
        }

        return $transactions;
    }

    public function getAll(): array
    {
        $stmt = $this->conn->query("
            SELECT *
            FROM inventory_transactions
            ORDER BY created_at DESC
        ");

        $rows = $stmt->fetchAll(
            \PDO::FETCH_ASSOC
        );

        $transactions = [];

        foreach ($rows as $row) {

            $transactions[] =
                InventoryTransactionFactory::create(
                    $row
                );
        }

        return $transactions;
    }
}