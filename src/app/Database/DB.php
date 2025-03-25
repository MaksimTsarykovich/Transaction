<?php

declare(strict_types=1);

namespace App\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * @mixin PDO
 */

readonly class DB
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }


}