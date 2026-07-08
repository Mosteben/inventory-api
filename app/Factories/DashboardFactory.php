<?php

namespace App\Factories;

use App\Models\Dashboard;

class DashboardFactory
{
    public static function make(
        array $data
    ): Dashboard
    {
        return new Dashboard(

            $data['users'] ?? 0,

            $data['products'] ?? 0,

            $data['categories'] ?? 0,

            $data['suppliers'] ?? 0,

            $data['orders'] ?? 0,

            (float)($data['revenue'] ?? 0),

            $data['lowStock'] ?? 0

        );
    }
}