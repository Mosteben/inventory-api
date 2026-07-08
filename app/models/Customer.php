<?php

namespace App\Models;

class Customer extends User
{
    public function __construct()
    {
        $this->role = 'customer';
    }

    public function getPermissions(): array
    {
        return [
            'orders.create',
            'orders.read.own'
        ];
    }
}