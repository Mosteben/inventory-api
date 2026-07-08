<?php

namespace App\Security;

class AuthContext
{
    /**
     * Current authenticated user payload
     */
    private static ?array $user = null;

    /**
     * Store authenticated user
     */
    public static function setUser(
        array $user
    ): void
    {
        self::$user = $user;
    }

    /**
     * Get authenticated user
     */
    public static function user(): ?array
    {
        return self::$user;
    }

    /**
     * Check if user exists
     */
    public static function check(): bool
    {
        return self::$user !== null;
    }

    /**
     * Get authenticated user id
     */
    public static function id(): ?int
    {
        return self::$user['id'] ?? null;
    }

    /**
     * Get authenticated user role
     */
    public static function role(): ?string
    {
        return self::$user['role'] ?? null;
    }

    /**
     * Get authenticated user email
     */
    public static function email(): ?string
    {
        return self::$user['email'] ?? null;
    }

    /**
     * Remove current user
     */
    public static function clear(): void
    {
        self::$user = null;
    }
}