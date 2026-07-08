<?php

namespace App\Services;

use Exception;
use App\Security\JwtService;
use App\Repositories\UserRepository;
use App\Validation\CustomerValidator;

class AuthService extends BaseService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();

        $this->userRepository =
            new UserRepository(
                $this->conn
            );
    }

    /**
     * Register Customer
     */
    public function register(
        array $data
    ): array
    {
        CustomerValidator::validateRegister(
            $data
        );

        $user =
            $this->userRepository
                ->findByEmail(
                    $data['email']
                );

        if ($user) {

            throw new Exception(
                'Email already exists'
            );
        }

        $data['password'] =
            password_hash(
                $data['password'],
                PASSWORD_DEFAULT
            );

        // Customer cannot choose role
        $data['role'] = 'customer';

        $data['status'] = 'active';

        $id =
            $this->userRepository
                ->create($data);

        return [

            'id' => $id,

            'message' =>
                'Customer registered successfully'

        ];
    }

    /**
     * Login
     */
    public function login(
        string $email,
        string $password
    ): array
    {
        $user =
            $this->userRepository
                ->findByEmail(
                    $email
                );

        if (!$user) {

            throw new Exception(
                'Invalid email or password'
            );
        }

        if (
            !password_verify(
                $password,
                $user->getPassword()
            )
        ) {

            throw new Exception(
                'Invalid email or password'
            );
        }

        if (
            $user->getStatus()
            !== 'active'
        ) {

            throw new Exception(
                'User account is inactive'
            );
        }

        $token =
            JwtService::generate([

                'id' =>
                    $user->getId(),

                'name' =>
                    $user->getName(),

                'email' =>
                    $user->getEmail(),

                'role' =>
                    $user->getRole()

            ]);

        return [

            'message' =>
                'Login successful',

            'token' =>
                $token,

            'user' =>
                $user

        ];
    }
}