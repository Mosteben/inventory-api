<?php

namespace App\Models;

class Admin extends User
{
    public function __construct()
    {
        $this->role = 'admin';
    }

    public function getPermissions(): array
    {
        return [
            '*'
        ];
    }
}