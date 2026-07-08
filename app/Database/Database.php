<?php

namespace App\Database;

use PDO;

class Database
{
    private ?PDO $connection = null;

    public function connect(): PDO
    {
        if ($this->connection === null) {

            $this->connection = new PDO(
                "mysql:host=localhost;dbname=inventory;charset=utf8",
                "root",
                ""
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }

        return $this->connection;
    }
}