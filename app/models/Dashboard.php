<?php

namespace App\Models;

class Dashboard
{
    private int $users;

    private int $products;

    private int $categories;

    private int $suppliers;

    private int $orders;

    private float $revenue;

    private int $lowStock;

    public function __construct(
        int $users,
        int $products,
        int $categories,
        int $suppliers,
        int $orders,
        float $revenue,
        int $lowStock
    ) {

        $this->users = $users;

        $this->products = $products;

        $this->categories = $categories;

        $this->suppliers = $suppliers;

        $this->orders = $orders;

        $this->revenue = $revenue;

        $this->lowStock = $lowStock;
    }

    public function getUsers(): int
    {
        return $this->users;
    }

    public function getProducts(): int
    {
        return $this->products;
    }

    public function getCategories(): int
    {
        return $this->categories;
    }

    public function getSuppliers(): int
    {
        return $this->suppliers;
    }

    public function getOrders(): int
    {
        return $this->orders;
    }

    public function getRevenue(): float
    {
        return $this->revenue;
    }

    public function getLowStock(): int
    {
        return $this->lowStock;
    }

    public function toArray(): array
    {
        return [

            'users' => $this->users,

            'products' => $this->products,

            'categories' => $this->categories,

            'suppliers' => $this->suppliers,

            'orders' => $this->orders,

            'revenue' => $this->revenue,

            'low_stock' => $this->lowStock

        ];
    }
}