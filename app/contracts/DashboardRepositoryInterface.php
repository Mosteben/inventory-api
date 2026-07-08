<?php

namespace App\Contracts;

use App\Models\Dashboard;

interface DashboardRepositoryInterface
{
    /**
     * Get dashboard statistics
     */
    public function getStatistics(): Dashboard;
}