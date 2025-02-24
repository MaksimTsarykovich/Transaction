<?php

namespace App\Database;


use App\Helpers\QueryBuilder;
use App\Helpers\Utils;

readonly class TransactionRepository
{
    private QueryBuilder $queryBuilder;

    public function __construct(DB $db)
    {
        $this->queryBuilder = new queryBuilder($db);
    }

    public function save(array $transaction): void
    {

        $this->queryBuilder->insert('transactions', $transaction);
    }

    public function saveAll(array $transactions): void
    {
        foreach ($transactions as $transaction) {
            $this->save($transaction);
        }
    }

    public function getAll(): array {
        return $this->queryBuilder->selectAll('transactions');
    }

}

