<?php

declare(strict_types=1);

namespace App;

use App\Database\DB;
use App\Database\QueryBuilder;

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