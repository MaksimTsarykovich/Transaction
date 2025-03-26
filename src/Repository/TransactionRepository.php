<?php

namespace src\Repository;


use Infrastructure\Database\DB;
use Infrastructure\Database\QueryBuilder;
use src\Exceptions\DatabaseCompareRowException;
use src\Exceptions\DatabaseInsertException;

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

