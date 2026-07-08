<?php

namespace App\Models;

use JsonSerializable;

class InventoryTransaction implements JsonSerializable
{
    private ?int $id = null;

    private int $productId;

    private int $userId;

    private string $type;

    private int $quantity;

    private ?string $note = null;

    private ?string $createdAt = null;

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

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(
        int $productId
    ): void
    {
        if ($productId <= 0) {

            throw new \InvalidArgumentException(
                'Invalid product id'
            );
        }

        $this->productId = $productId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(
        int $userId
    ): void
    {
        if ($userId <= 0) {

            throw new \InvalidArgumentException(
                'Invalid user id'
            );
        }

        $this->userId = $userId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(
        string $type
    ): void
    {
        $type = strtoupper($type);

        if (
            !in_array(
                $type,
                ['IN', 'OUT'],
                true
            )
        ) {

            throw new \InvalidArgumentException(
                'Transaction type must be IN or OUT'
            );
        }

        $this->type = $type;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(
        int $quantity
    ): void
    {
        if ($quantity <= 0) {

            throw new \InvalidArgumentException(
                'Quantity must be greater than zero'
            );
        }

        $this->quantity = $quantity;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(
        ?string $note
    ): void
    {
        $this->note = $note;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(
        ?string $createdAt
    ): void
    {
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): array
    {
        return [

            'id' => $this->id,

            'product_id' => $this->productId,

            'user_id' => $this->userId,

            'type' => $this->type,

            'quantity' => $this->quantity,

            'note' => $this->note,

            'created_at' => $this->createdAt
        ];
    }
}