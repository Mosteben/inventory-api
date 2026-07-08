<?php

namespace App\Models;

use JsonSerializable;

class OrderItem implements JsonSerializable
{
    private ?int $id = null;

    private Product $product;

    private int $quantity;

    private float $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException(
                'Quantity must be greater than zero'
            );
        }

        $this->quantity = $quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        if ($price < 0) {
            throw new \InvalidArgumentException(
                'Price cannot be negative'
            );
        }

        $this->price = $price;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'product' => $this->product,
            'quantity' => $this->quantity,
            'price' => $this->price
        ];
    }
}

