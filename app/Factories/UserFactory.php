<?php

namespace App\Factories;

use Exception;
use App\Models\User;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Customer;

class UserFactory
{
    public static function create(array $data): User
    {
        switch ($data['role']) {

            case 'admin':
                $user = new Admin();
                break;

            case 'employee':
                $user = new Employee();
                break;

            case 'customer':
                $user = new Customer();
                break;

            default:
                throw new Exception(
                    'Invalid user role'
                );
        }

        if (isset($data['id'])) {
            $user->setId(
                (int)$data['id']
            );
        }

        $user->setName(
            $data['name']
        );

        $user->setEmail(
            $data['email']
        );

        $user->setPassword(
            $data['password']
        );

        $user->setPhone(
            $data['phone']
        );

        $user->setAddress(
            $data['address'] ?? null
        );

        $user->setStatus(
            $data['status'] ?? 'active'
        );

        return $user;
    }
}