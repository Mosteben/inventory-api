<?php

namespace App\Services;

use App\Repositories\DashboardRepository;

class DashboardService extends BaseService
{
    private DashboardRepository $repository;

    public function __construct()
    {
        parent::__construct();

        $this->repository =
            new DashboardRepository(
                $this->conn
            );
    }

    /**
     * Get Dashboard Statistics
     */
    public function getStatistics(): array
    {
        return
            $this->repository
                ->getStatistics()
                ->toArray();
    }
}