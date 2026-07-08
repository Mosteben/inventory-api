<?php

namespace App\Controllers;

use Exception;
use App\Services\AuthService;

class AuthController
{
    private static AuthService $service;

    private static function service(): AuthService
    {
        if (!isset(self::$service)) {

            self::$service =
                new AuthService();
        }

        return self::$service;
    }

    /**
     * POST /auth/register
     */
    public static function register(): void
    {
        try {

            $data =
                json_decode(
                    file_get_contents(
                        'php://input'
                    ),
                    true
                );

            $result =
                self::service()
                    ->register($data);

            http_response_code(201);

            echo json_encode(
                $result
            );

        } catch (Exception $e) {

            http_response_code(400);

            echo json_encode([
                'message' =>
                    $e->getMessage()
            ]);
        }
    }

    /**
     * POST /auth/login
     */
    public static function login(): void
    {
        try {

            $data =
                json_decode(
                    file_get_contents(
                        'php://input'
                    ),
                    true
                );

            $result =
                self::service()
                    ->login(
                        $data['email'],
                        $data['password']
                    );

            echo json_encode(
                $result
            );

        } catch (Exception $e) {

            http_response_code(401);

            echo json_encode([
                'message' =>
                    $e->getMessage()
            ]);
        }
    }
}