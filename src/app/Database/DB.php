<?php

declare(strict_types=1);

namespace App\Database;

use App\Config;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

readonly class  DB
{
    private Connection $connection;
    public  QueryBuilder $queryBuilder;

    public function __construct(Config $config)
    {
        $this->connection = DriverManager::getConnection($config->db);
        $createQueryBuilder=$this->connection->createQueryBuilder();
        $this->queryBuilder = $createQueryBuilder;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }

}