<?php

namespace App\Factories;

use App\Models\OrderItem;
use App\Models\Product;

class OrderItemFactory
{
   
    public static function createForCreate(
        array $data
    ): OrderItem
    {
        $item = new OrderItem();

        $product = new Product();

        $product->setId(
            (int)$data['product_id']
        );

        $item->setProduct(
            $product
        );

        $item->setQuantity(
            (int)$data['quantity']
        );

        $item->setPrice(
            0
        );

        return $item;
    }

    
    public static function createFromDatabase(
        array $data
    ): OrderItem
    {
        $item = new OrderItem();

        if (isset($data['id'])) {
            $item->setId(
                (int)$data['id']
            );
        }

        $item->setProduct(

            ProductFactory::create([

                'id' => $data['product_id'],

                'name' => $data['name'],

                'description' => $data['description'],

                'sku' => $data['sku'],

                'price' => $data['product_price'],

                'quantity' => $data['quantity'],

                'category_id' => $data['category_id'],

                'category_name' => $data['category_name'],

                'supplier_id' => $data['supplier_id'],

                'supplier_name' => $data['supplier_name'],

                'status' => $data['status']
            ])
        );

        $item->setQuantity(
            (int)$data['order_quantity']
        );

        $item->setPrice(
            (float)$data['price']
        );

        return $item;
    }
}

