<?php

namespace App\Models;

use JsonSerializable;
use App\Enums\ActivityAction;

class ActivityLog implements JsonSerializable
{
    private ?int $id = null;

    private int $userId;

    private string $action;

    private string $entity;

    private int $entityId;

    private ?string $description = null;

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

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(
        string $action
    ): void
    {
        $action = strtoupper($action);

        if (
            !in_array(
                $action,
                ActivityAction::values(),
                true
            )
        ) {

            throw new \InvalidArgumentException(
                'Invalid activity action'
            );
        }

        $this->action = $action;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function setEntity(
        string $entity
    ): void
    {
        if (trim($entity) === '') {

            throw new \InvalidArgumentException(
                'Entity is required'
            );
        }

        $this->entity = strtoupper($entity);
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function setEntityId(
        int $entityId
    ): void
    {
        if ($entityId <= 0) {

            throw new \InvalidArgumentException(
                'Invalid entity id'
            );
        }

        $this->entityId = $entityId;
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

            'user_id' => $this->userId,

            'action' => $this->action,

            'entity' => $this->entity,

            'entity_id' => $this->entityId,

            'description' => $this->description,

            'created_at' => $this->createdAt

        ];
    }
}