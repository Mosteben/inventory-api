<?php

namespace App\Middleware;

use Exception;
use App\Security\AuthContext;
use App\Security\JwtValidator;

class AuthMiddleware
{
    /**
     * Authenticate request
     */
    public static function handle(): void
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            self::unauthorized(
                'Authorization header is missing.'
            );
        }

        $authorization = trim(
            $headers['Authorization']
        );

        $parts = explode(
            ' ',
            $authorization
        );

        if (
            count($parts) !== 2 ||
            strtolower($parts[0]) !== 'bearer'
        ) {

            self::unauthorized(
                'Invalid authorization header.'
            );
        }

        $token = trim($parts[1]);

        if (empty($token)) {

            self::unauthorized(
                'Token is missing.'
            );
        }

        try {

            // Validate token
            if (!JwtValidator::validate($token)) {

                self::unauthorized(
                    'Invalid or expired token.'
                );
            }

            // Get payload
            $payload = JwtValidator::getPayload($token);

            // Save authenticated user
            AuthContext::setUser($payload);

        } catch (Exception $e) {

            self::unauthorized(
                $e->getMessage()
            );
        }
    }

    /**
     * Unauthorized response
     */
    private static function unauthorized(
        string $message
    ): void
    {
        http_response_code(401);

        header(
            'Content-Type: application/json'
        );

        echo json_encode([
            'success' => false,
            'message' => $message
        ]);

        exit;
    }
}