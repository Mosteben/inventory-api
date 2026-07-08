<?php

namespace App\Factories;

use App\Models\InventoryTransaction;

class InventoryTransactionFactory
{
    public static function create(
        array $data
    ): InventoryTransaction
    {
        $transaction =
            new InventoryTransaction();

        if (
            isset($data['id'])
        ) {

            $transaction->setId(
                (int)$data['id']
            );
        }

        if (
            isset($data['product_id'])
        ) {

            $transaction->setProductId(
                (int)$data['product_id']
            );
        }

        if (
            isset($data['user_id'])
        ) {

            $transaction->setUserId(
                (int)$data['user_id']
            );
        }

        if (
            isset($data['type'])
        ) {

            $transaction->setType(
                $data['type']
            );
        }

        if (
            isset($data['quantity'])
        ) {

            $transaction->setQuantity(
                (int)$data['quantity']
            );
        }

        $transaction->setNote(
            $data['note'] ?? null
        );

        $transaction->setCreatedAt(
            $data['created_at'] ?? null
        );

        return $transaction;
    }
}