<?php

namespace App\Security;

use App\Config\Env;
use RuntimeException;

class JwtService
{
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
                self::getSecret()
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
        $secret = Env::get('JWT_SECRET');

        if (!$secret) {
            throw new RuntimeException(
                'JWT_SECRET is not configured.'
            );
        }

        return $secret;
    }
}