<?php

require_once __DIR__ . '/vendor/autoload.php';
var_dump(class_exists(\App\Security\JwtService::class));

use App\Security\JwtService;
use App\Security\JwtValidator;

echo "<pre>";

$token = JwtService::generate([
    'id'    => 1,
    'email' => 'admin@gmail.com',
    'role'  => 'admin'
]);

echo "TOKEN:\n\n";
echo $token;

echo "\n\n=====================\n\n";

echo "VALID:\n";
var_dump(
    JwtValidator::validate($token)
);

echo "\n=====================\n\n";

echo "PAYLOAD:\n";
print_r(
    JwtValidator::getPayload($token)
);

echo "</pre>";