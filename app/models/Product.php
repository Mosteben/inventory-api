<?php

namespace App\Models;

use JsonSerializable;

class Product implements JsonSerializable
{
    private ?int $id = null;

    private ?string $name = null;

    private ?string $description = null;

    private ?string $sku = null;

    private float $price = 0;

    private int $quantity = 0;

    private ?Category $category = null;

    private ?Supplier $supplier = null;

    private string $status = 'active';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(
        int $id
    ): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(
        string $name
    ): void
    {
        if (trim($name) === '') {
            throw new \InvalidArgumentException(
                'Product name is required'
            );
        }

        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(
        ?string $description
    ): void
    {
        $this->description = $description;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(
        string $sku
    ): void
    {
        if (trim($sku) === '') {
            throw new \InvalidArgumentException(
                'SKU is required'
            );
        }

        $this->sku = $sku;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(
        float $price
    ): void
    {
        if ($price < 0) {
            throw new \InvalidArgumentException(
                'Price cannot be negative'
            );
        }

        $this->price = $price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(
        int $quantity
    ): void
    {
        if ($quantity < 0) {
            throw new \InvalidArgumentException(
                'Quantity cannot be negative'
            );
        }

        $this->quantity = $quantity;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(
        ?Category $category
    ): void
    {
        $this->category = $category;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(
        ?Supplier $supplier
    ): void
    {
        $this->supplier = $supplier;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(
        string $status
    ): void
    {
        $this->status = $status;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'sku' => $this->sku,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'category' => $this->category,
            'supplier' => $this->supplier,
            'status' => $this->status
        ];
    }
}