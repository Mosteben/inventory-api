<?php

namespace App\Services;

use App\Factories\ActivityLogFactory;
use App\Repositories\ActivityLogRepository;

class ActivityLogService extends BaseService
{
    private ActivityLogRepository $repository;

    public function __construct()
    {
        parent::__construct();

        $this->repository =
            new ActivityLogRepository(
                $this->conn
            );
    }

    public function log(
        array $data
    ): int
    {
        $activityLog =
            ActivityLogFactory::create(
                $data
            );

        return $this->repository->create(
            $activityLog
        );
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getByUserId(
        int $userId
    ): array
    {
        return $this->repository->getByUserId(
            $userId
        );
    }
}