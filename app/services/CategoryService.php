<?php

namespace App\Services;

use Exception;
use App\Contracts\CrudInterface;
use App\Factories\CategoryFactory;
use App\Repositories\CategoryRepository;

class CategoryService
    extends BaseService

{
    private CategoryRepository $repository;

    public function __construct()
    {
        parent::__construct();

        $this->repository =
            new CategoryRepository(
                $this->conn
            );
    }

    public function getAll(): array
    {
        return $this->repository
            ->getAll();
    }

    public function getById(
        int $id
    )
    {
        return $this->repository
            ->getById($id);
    }

    public function create(
        array $data
    ): array
    {
        $category =
            CategoryFactory::create(
                $data
            );

        $id =
            $this->repository
                ->create(
                    $category
                );

        return [
            'id' => $id,
            'message' =>
                'Category created successfully'
        ];
    }

    public function update(
        int $id,
        array $data
    ): bool
    {
        $category =
            $this->repository
                ->getById($id);

        if (!$category) {
            throw new Exception(
                'Category not found'
            );
        }

        $updatedCategory =
            CategoryFactory::create(
                array_merge(
                    [
                        'id' => $id
                    ],
                    $data
                )
            );

        return $this->repository
            ->update(
                $id,
                $updatedCategory
            );
    }

    public function delete(
        int $id
    ): bool
    {
        $category =
            $this->repository
                ->getById($id);

        if (!$category) {
            throw new Exception(
                'Category not found'
            );
        }

        if (
            $this->repository
                ->hasProducts($id)
        ) {
            throw new Exception(
                'Category has products'
            );
        }

        return $this->repository
            ->delete($id);
    }
}