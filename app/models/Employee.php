<?php

namespace App\Models;

class Employee extends User
{
    public function __construct()
    {
        $this->role = 'employee';
    }

    public function getPermissions(): array
    {
        return [
            'products.read',
            'products.create',
            'products.update',

            'categories.read',

            'suppliers.read',

            'orders.read',
            'orders.create',
            'orders.cancel'
        ];
    }
}