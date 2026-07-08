<?php

namespace App\Controllers;

use Exception;
use App\Services\DashboardService;
use App\Utils\Response;

class DashboardController
{
    private static DashboardService $service;

    private static function service(): DashboardService
    {
        if (!isset(self::$service)) {

            self::$service =
                new DashboardService();
        }

        return self::$service;
    }

    /**
     * GET /dashboard
     */
    public static function index(): void
    {
        try {

            $dashboard =
                self::service()
                    ->getStatistics();

            Response::json(
                $dashboard
            );

        } catch (Exception $e) {

            Response::error(
                $e->getMessage(),
                500
            );
        }
    }
}