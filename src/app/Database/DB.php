<?php

declare(strict_types=1);

namespace App\Database;

use Doctrine\DBAL\DriverManager;

/**
 * @mixin PDO
 */

readonly class DB
{
    private DriverManager $conn;

    public function __construct()
    {
    }


}