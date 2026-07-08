<?php

namespace App\Models;

abstract class Person
{
    protected ?int $id = null;

    protected string $name;

    protected string $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        if (trim($name) === '') {
            throw new \InvalidArgumentException(
                'Name is required'
            );
        }

        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        if (
            !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        ) {
            throw new \InvalidArgumentException(
                'Invalid email'
            );
        }

        $this->email = $email;
    }
}