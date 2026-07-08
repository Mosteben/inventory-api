<?php

namespace App\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class ProductFactory
{
    public static function create(array $data): Product
    {
        $product = new Product();

        if (isset($data['id'])) {
            $product->setId((int) $data['id']);
        }

        if (
            isset($data['name']) &&
            $data['name'] !== null &&
            trim($data['name']) !== ''
        ) {
            $product->setName($data['name']);
        }

        $product->setDescription(
            $data['description'] ?? null
        );

        if (
            isset($data['sku']) &&
            $data['sku'] !== null &&
            trim($data['sku']) !== ''
        ) {
            $product->setSku($data['sku']);
        }

        $product->setPrice(
            (float)($data['price'] ?? 0)
        );

        $product->setQuantity(
            (int)($data['quantity'] ?? 0)
        );

        if (!empty($data['category_id'])) {

            $category = new Category();

            $category->setId(
                (int)$data['category_id']
            );

            if (
                isset($data['category_name']) &&
                $data['category_name'] !== null &&
                trim($data['category_name']) !== ''
            ) {
                $category->setName(
                    $data['category_name']
                );
            }

            $product->setCategory(
                $category
            );
        }

        if (!empty($data['supplier_id'])) {

            $supplier = new Supplier();

            $supplier->setId(
                (int)$data['supplier_id']
            );

            if (
                isset($data['supplier_name']) &&
                $data['supplier_name'] !== null &&
                trim($data['supplier_name']) !== ''
            ) {
                $supplier->setName(
                    $data['supplier_name']
                );
            }

            $product->setSupplier(
                $supplier
            );
        }

        if (isset($data['status'])) {
            $product->setStatus(
                $data['status']
            );
        }

        return $product;
    }
}

