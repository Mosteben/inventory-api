<?php

namespace App\Validation;

class CustomerValidator
{
    public static function validateRegister(
        array $data
    ): void
    {
        if (
            empty($data['name'])
        ) {
            throw new \InvalidArgumentException(
                'Name is required'
            );
        }

        if (
            empty($data['email'])
        ) {
            throw new \InvalidArgumentException(
                'Email is required'
            );
        }

        if (
            !filter_var(
                $data['email'],
                FILTER_VALIDATE_EMAIL
            )
        ) {
            throw new \InvalidArgumentException(
                'Invalid email'
            );
        }

        if (
            empty($data['password'])
        ) {
            throw new \InvalidArgumentException(
                'Password is required'
            );
        }

        if (
            strlen($data['password']) < 8
        ) {
            throw new \InvalidArgumentException(
                'Password must be at least 8 characters'
            );
        }

        if (
            empty($data['phone'])
        ) {
            throw new \InvalidArgumentException(
                'Phone is required'
            );
        }
    }
}