<?php

namespace App\Config;

class Env
{
    private static bool $loaded = false;

    /**
     * Load key=value pairs from a .env file into the environment.
     * Existing environment variables are never overwritten.
     */
    public static function load(string $path): void
    {
        if (self::$loaded) {
            return;
        }

        self::$loaded = true;

        if (!is_file($path)) {
            return;
        }

        $lines = file(
            $path,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (!str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);

            $key = trim($key);
            $value = trim(trim($value), "\"'");

            if ($key === '' || getenv($key) !== false) {
                continue;
            }

            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $value = getenv($key);

        return $value === false ? $default : $value;
    }
}
