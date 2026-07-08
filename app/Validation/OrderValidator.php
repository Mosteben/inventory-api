<?php

namespace App\Validation;

use Exception;

class OrderValidator
{
    public static function validate(
        array $data
    ): void
    {    
        if (empty($data['items'])) {
            throw new Exception(
                'items are required'
            );
        }
    }
}