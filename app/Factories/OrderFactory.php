<?php

namespace App\Factories;

use App\Models\Order;

class OrderFactory
{
    
    public static function createForCreate(array $data): Order
    {
        $order = new Order();
        if (!empty($data['items'])) {

            foreach ($data['items'] as $item) {

                $order->addItem(
                    OrderItemFactory::createForCreate($item)
                );
            }
        }

        return $order;
    }

    
    public static function createFromDatabase(array $data): Order
    {
        $order = new Order();

        if (isset($data['id'])) {
            $order->setId(
                (int)$data['id']
            );
        }

        $order->setUserId(
            (int)$data['user_id']
        );

        $order->setTotal(
            (float)$data['total']
        );

        $order->setStatus(
            $data['status']
        );

        return $order;
    }
}

