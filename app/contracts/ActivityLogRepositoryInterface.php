<?php

namespace App\Contracts;

use App\Models\ActivityLog;

interface ActivityLogRepositoryInterface
{
    public function create(
        ActivityLog $log
    ): int;

    public function getAll(): array;

    public function getByUserId(
        int $userId
    ): array;
}