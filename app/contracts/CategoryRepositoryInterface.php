<?php

namespace App\Contracts;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function getAll(): array;

    public function getById(
        int $id
    ): ?Category;

    public function create(
        Category $category
    ): int;

    public function update(
        int $id,
        Category $category
    ): bool;

    public function hasProducts(
        int $id
    ): bool;

    public function delete(
        int $id
    ): bool;
}