<?php

namespace App\Security;

class JwtEncoder
{
    /**
     * Encode string using Base64Url
     */
    public static function base64UrlEncode(
        string $data
    ): string
    {
        return rtrim(
            strtr(
                base64_encode($data),
                '+/',
                '-_'
            ),
            '='
        );
    }

    /**
     * Encode JWT Header
     */
    public static function encodeHeader(): string
    {
        return self::base64UrlEncode(
            json_encode([
                'alg' => 'HS256',
                'typ' => 'JWT'
            ])
        );
    }

    /**
     * Encode JWT Payload
     */
    public static function encodePayload(
        array $payload
    ): string
    {
        return self::base64UrlEncode(
            json_encode($payload)
        );
    }
}