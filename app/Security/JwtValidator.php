<?php

namespace App\Security;

class JwtValidator
{
    /**
     * Validate Token
     */
    public static function validate(
        string $token
    ): bool
    {
        $parts = explode(
            '.',
            $token
        );

        if (count($parts) !== 3) {
            return false;
        }

        [
            $header,
            $payload,
            $signature
        ] = $parts;

        $expectedSignature =
            JwtSignature::generate(
                $header,
                $payload,
                JwtService::getSecret()
            );

        if (
            !hash_equals(
                $expectedSignature,
                $signature
            )
        ) {
            return false;
        }

        $payloadData =
            JwtDecoder::decodePayload(
                $payload
            );

        if (
            !isset($payloadData['exp'])
        ) {
            return false;
        }

        if (
            time() >
            $payloadData['exp']
        ) {
            return false;
        }

        return true;
    }

    /**
     * Get Payload
     */
    public static function getPayload(
        string $token
    ): array
    {
        if (
            !self::validate($token)
        ) {
            throw new JwtException(
                'Invalid Token'
            );
        }

        $parts = explode(
            '.',
            $token
        );

        return JwtDecoder::decodePayload(
            $parts[1]
        );
    }
}