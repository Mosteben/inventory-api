<?php

namespace App\Database;

use PDO;
use App\Config\Env;

class Database
{
    private ?PDO $connection = null;

    public function connect(): PDO
    {
        if ($this->connection === null) {

            $host = Env::get('DB_HOST', 'localhost');
            $name = Env::get('DB_NAME', 'inventory');
            $user = Env::get('DB_USER', 'root');
            $pass = Env::get('DB_PASS', '');

            $this->connection = new PDO(
                "mysql:host={$host};dbname={$name};charset=utf8",
                $user,
                $pass
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }

        return $this->connection;
    }
}