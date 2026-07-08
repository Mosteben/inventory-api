<?php

namespace App\Services;

use App\Database\Database;

abstract class BaseService
{
    protected \PDO $conn;

    public function __construct()
    {
        $database = new Database();

        $this->conn = $database->connect();
    }
}