<?php

namespace App\Factories;

use App\Models\Category;

class CategoryFactory
{
    public static function create(array $data): Category
    {
        $category = new Category();

        if (isset($data['id'])) {
            $category->setId(
                (int)$data['id']
            );
        }

        if (
            isset($data['name']) &&
            $data['name'] !== null &&
            trim($data['name']) !== ''
        ) {
            $category->setName(
                $data['name']
            );
        }

        $category->setDescription(
            $data['description'] ?? null
        );

        return $category;
    }
}

