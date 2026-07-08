<?php

namespace App\Security;

class JwtDecoder
{
    /**
     * Decode Base64Url string
     */
    public static function base64UrlDecode(
        string $data
    ): string
    {
        $remainder = strlen($data) % 4;

        if ($remainder) {
            $data .= str_repeat(
                '=',
                4 - $remainder
            );
        }

        return base64_decode(
            strtr(
                $data,
                '-_',
                '+/'
            )
        );
    }

    /**
     * Decode Header
     */
    public static function decodeHeader(
        string $header
    ): array
    {
        return json_decode(
            self::base64UrlDecode($header),
            true
        );
    }

    /**
     * Decode Payload
     */
    public static function decodePayload(
        string $payload
    ): array
    {
        return json_decode(
            self::base64UrlDecode($payload),
            true
        );
    }
}