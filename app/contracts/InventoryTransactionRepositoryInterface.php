<?php

namespace App\Contracts;

use App\Models\InventoryTransaction;

interface InventoryTransactionRepositoryInterface
{
    public function create(
        InventoryTransaction $transaction
    ): int;

    public function getByProductId(
        int $productId
    ): array;

    public function getAll(): array;
}