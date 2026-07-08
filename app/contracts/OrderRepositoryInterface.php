<?php

namespace App\Contracts;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function getAll(): array;

    public function getById(int $id): ?Order;

    public function create(array $data): int;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function createOrderItem(array $item): int;

    public function getOrderItems(int $orderId): array;
}