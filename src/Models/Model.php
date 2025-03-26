<?php

declare(strict_types=1);

namespace src\Models;

use Infrastructure\Database\DB;
use Infrastructure\Database\QueryBuilder;

abstract class Model
{
    protected DB $db;
    protected queryBuilder $queryBuilder;

    public function __construct(DB $db)
    {
        $this->db = $db;
        $this->queryBuilder = new QueryBuilder($db);
    }
}