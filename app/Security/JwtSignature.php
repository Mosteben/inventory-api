<?php

namespace App\Security;

class JwtSignature
{
    /**
     * Generate JWT Signature
     */
    public static function generate(
        string $header,
        string $payload,
        string $secret
    ): string
    {
        $signature = hash_hmac(
            'sha256',
            $header . '.' . $payload,
            $secret,
            true
        );

        return JwtEncoder::base64UrlEncode(
            $signature
        );
    }
}