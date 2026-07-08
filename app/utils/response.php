<?php

namespace App\Utils;

class Response
{
    public static function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);

        header("Content-Type: application/json");

        echo json_encode($data);

        return;
    }

    public static function error($message, $statusCode = 400)
    {
        http_response_code($statusCode);

        header("Content-Type: application/json");

        echo json_encode([
            "error" => $message
        ]);

        return;
    }
}