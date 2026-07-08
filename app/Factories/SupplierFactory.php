<?php

namespace App\Factories;

use App\Models\Supplier;

class SupplierFactory
{
    public static function create(array $data): Supplier
    {
        $supplier = new Supplier();

        if (isset($data['id'])) {
            $supplier->setId(
                (int)$data['id']
            );
        }

        if (
            isset($data['name']) &&
            $data['name'] !== null &&
            trim($data['name']) !== ''
        ) {
            $supplier->setName(
                $data['name']
            );
        }

        $supplier->setEmail(
            $data['email'] ?? null
        );

        $supplier->setPhone(
            $data['phone'] ?? null
        );

        $supplier->setAddress(
            $data['address'] ?? null
        );

        return $supplier;
    }
}

