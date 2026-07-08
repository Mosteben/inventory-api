<?php

namespace App\Security;

class JwtService
{
    /**
     * Secret Key
     */
    private const SECRET_KEY =
        'InventoryAPI2026@Op';

    /**
     * Token Lifetime
     * 1 Hour
     */
    private const TOKEN_LIFETIME = 3600;

    /**
     * Generate JWT
     */
    public static function generate(
        array $payload
    ): string
    {
        $header =
            JwtEncoder::encodeHeader();

        $payload['iat'] = time();

        $payload['exp'] =
            time() + self::TOKEN_LIFETIME;

        $encodedPayload =
            JwtEncoder::encodePayload(
                $payload
            );

        $signature =
            JwtSignature::generate(
                $header,
                $encodedPayload,
                self::SECRET_KEY
            );

        return
            $header .
            '.' .
            $encodedPayload .
            '.' .
            $signature;
    }

    /**
     * Secret Getter
     */
    public static function getSecret(): string
    {
        return self::SECRET_KEY;
    }
}