<?php

namespace App\Models;

use JsonSerializable;

class Order implements JsonSerializable
{
    private ?int $id = null;

    private int $userId;

    private float $total = 0;

    private string $status = 'pending';

    /**
     * @var OrderItem[]
     */
    private array $items = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException(
                'Invalid user id'
            );
        }

        $this->userId = $userId;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        if ($total < 0) {
            throw new \InvalidArgumentException(
                'Total cannot be negative'
            );
        }

        $this->total = $total;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return OrderItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param OrderItem[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function addItem(OrderItem $item): void
    {
        $this->items[] = $item;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'total' => $this->total,
            'status' => $this->status,
            'items' => $this->items
        ];
    }
}

