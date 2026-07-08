<?php

namespace App\Validation;

class Validator
{
    public static function required(
        array $data,
        array $fields
    )
    {
        $errors = [];

        foreach ($fields as $field) {
            if (
                !isset($data[$field]) ||
                empty($data[$field])
            ) {
                $errors[] =
                    "{$field} is required";
            }
        }

        return $errors;
    }
}