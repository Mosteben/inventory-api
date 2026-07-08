<?php

namespace App\Services;

use App\Contracts\CrudInterface;
use App\Factories\SupplierFactory;
use App\Repositories\SupplierRepository;

class SupplierService
    extends BaseService
    
{
    private SupplierRepository $repository;

    public function __construct()
    {
        parent::__construct();

        $this->repository =
            new SupplierRepository(
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
        $supplier =
            SupplierFactory::create(
                $data
            );

        $id =
            $this->repository->create(
                $supplier
            );

        return [
            'id' => $id,
            'message' =>
                'Supplier created successfully'
        ];
    }

    public function update(
        int $id,
        array $data
    ): bool
    {
        $supplier =
            SupplierFactory::create(
                $data
            );

        return $this->repository->update(
            $id,
            $supplier
        );
    }

    public function delete(
        int $id
    ): bool
    {
        if (
            $this->repository
                ->hasProducts(
                    $id
                )
        ) {
            throw new \Exception(
                'Supplier has products'
            );
        }

        return $this->repository
            ->delete($id);
    }
}