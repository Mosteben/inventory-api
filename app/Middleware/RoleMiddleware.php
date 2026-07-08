<?php

namespace App\Middleware;

use App\Security\AuthContext;

class RoleMiddleware
{
    /**
     * Check user role
     */
    public static function handle(
        array $allowedRoles
    ): void
    {
        if (!AuthContext::check()) {

            self::forbidden(
                'User is not authenticated.'
            );
        }

        $role = AuthContext::role();

        if (
            !in_array(
                $role,
                $allowedRoles,
                true
            )
        ) {

            self::forbidden(
                'You do not have permission to access this resource.'
            );
        }
    }

    /**
     * Forbidden response
     */
    private static function forbidden(
        string $message
    ): void
    {
        http_response_code(403);

        header(
            'Content-Type: application/json'
        );

        echo json_encode([
            'success' => false,
            'message' => $message
        ]);

        exit;
    }}
