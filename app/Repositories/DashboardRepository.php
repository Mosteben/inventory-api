<?php

namespace App\Repositories;

use PDO;
use App\Models\Dashboard;
use App\Factories\DashboardFactory;
use App\Contracts\DashboardRepositoryInterface;

class DashboardRepository extends BaseRepository implements DashboardRepositoryInterface
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
    }

    public function getStatistics(): Dashboard
    {
        $users = $this->conn
            ->query("SELECT COUNT(*) FROM users")
            ->fetchColumn();

        $products = $this->conn
            ->query("SELECT COUNT(*) FROM products")
            ->fetchColumn();

        $categories = $this->conn
            ->query("SELECT COUNT(*) FROM categories")
            ->fetchColumn();

        $suppliers = $this->conn
            ->query("SELECT COUNT(*) FROM suppliers")
            ->fetchColumn();

        $orders = $this->conn
            ->query("SELECT COUNT(*) FROM orders")
            ->fetchColumn();

        $revenue = $this->conn
            ->query("SELECT IFNULL(SUM(total),0) FROM orders")
            ->fetchColumn();

        $lowStock = $this->conn
            ->query("SELECT COUNT(*) FROM products WHERE quantity <= 5")
            ->fetchColumn();

        return DashboardFactory::make([

            'users' => (int)$users,

            'products' => (int)$products,

            'categories' => (int)$categories,

            'suppliers' => (int)$suppliers,

            'orders' => (int)$orders,

            'revenue' => (float)$revenue,

            'lowStock' => (int)$lowStock

        ]);
    }
}