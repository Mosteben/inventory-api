<?php

namespace App\Contracts;

use App\Models\Supplier;

interface SupplierRepositoryInterface
{
    /**
     * @return Supplier[]
     */
    public function getAll(): array;

    public function getById(
        int $id
    ): ?Supplier;

    public function create(
        Supplier $supplier
    ): int;

    public function update(
        int $id,
        Supplier $supplier
    ): bool;

    public function delete(
        int $id
    ): bool;

    public function hasProducts(
        int $id
    ): bool;
}