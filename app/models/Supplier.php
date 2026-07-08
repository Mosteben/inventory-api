<?php

namespace App\Models;

use JsonSerializable;

class Supplier implements JsonSerializable
{
    private ?int $id = null;

    private ?string $name = null;

    private ?string $email = null;

    private ?string $phone = null;

    private ?string $address = null;

    /**
     * @var Product[]
     */
    private array $products = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        if (trim($name) === '') {
            throw new \InvalidArgumentException(
                'Supplier name is required'
            );
        }

        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        if (
            $email !== null &&
            !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            throw new \InvalidArgumentException(
                'Invalid email address'
            );
        }

        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'address' => $this->address
        ];
    }
}

