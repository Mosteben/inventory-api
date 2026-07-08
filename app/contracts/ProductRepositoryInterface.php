<?php

namespace App\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function getAll(): array;

    public function getById(
        int $id
    ): ?Product;

    public function create(
        Product $product
    ): int;

    public function update(
        int $id,
        Product $product
    ): bool;

    public function delete(
        int $id
    ): bool;
    public function getLowStock(
    int $limit = 5
): array;
public function search(
    string $keyword
): array;
}