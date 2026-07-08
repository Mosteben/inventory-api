<?php

namespace App\Repositories;

use App\Models\User;
use App\Factories\UserFactory;

class UserRepository extends BaseRepository
{
    public function getAll(): array
    {
        $stmt = $this->conn->query("
            SELECT *
            FROM users
            ORDER BY id DESC
        ");

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $users = [];

        foreach ($rows as $row) {

            $users[] = UserFactory::create(
                $row
            );
        }

        return $users;
    }

    public function getById(
        int $id
    ): ?User
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        $row = $stmt->fetch(
            \PDO::FETCH_ASSOC
        );

        if (!$row) {
            return null;
        }

        return UserFactory::create(
            $row
        );
    }

    public function findByEmail(
        string $email
    ): ?User
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE email = :email
            LIMIT 1
        ");

        $stmt->execute([
            ':email' => $email
        ]);

        $row = $stmt->fetch(
            \PDO::FETCH_ASSOC
        );

        if (!$row) {
            return null;
        }

        return UserFactory::create(
            $row
        );
    }

    public function create(
        array $data
    ): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO users
            (
                name,
                email,
                password,
                phone,
                address,
                role,
                status
            )
            VALUES
            (
                :name,
                :email,
                :password,
                :phone,
                :address,
                :role,
                :status
            )
        ");

        $stmt->execute([
            ':name'     => $data['name'],
            ':email'    => $data['email'],
            ':password' => $data['password'],
            ':phone'    => $data['phone'],
            ':address'  => $data['address'],
            ':role'     => $data['role'],
            ':status'   => $data['status']
        ]);

        return (int)$this->conn->lastInsertId();
    }

    public function update(
        int $id,
        array $data
    ): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE users
            SET
                name = :name,
                email = :email,
                phone = :phone,
                address = :address,
                status = :status
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id'      => $id,
            ':name'    => $data['name'],
            ':email'   => $data['email'],
            ':phone'   => $data['phone'],
            ':address' => $data['address'],
            ':status'  => $data['status']
        ]);
    }

    public function updatePassword(
        int $id,
        string $password
    ): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE users
            SET password = :password
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id,
            ':password' => $password
        ]);
    }

    public function delete(
        int $id
    ): bool
    {
        $stmt = $this->conn->prepare("
            DELETE
            FROM users
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}