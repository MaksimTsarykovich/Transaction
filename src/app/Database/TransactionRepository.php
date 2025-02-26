<?php

namespace App\Database;


use App\Exceptions\DatabaseCompareRowException;
use App\Exceptions\DatabaseInsertException;
use App\Helpers\QueryBuilder;
use App\Helpers\Utils;

readonly class TransactionRepository
{
    private QueryBuilder $queryBuilder;

    public function __construct(DB $db)
    {
        $this->queryBuilder = new queryBuilder($db);
    }

    /**
     * @throws DatabaseCompareRowException
     * @throws DatabaseInsertException
     */
    public function save(array $transaction): void
    {
        $this->queryBuilder->insert('transactions', $transaction);
    }

}

