<?php

namespace App\Database;


use App\Helpers\QueryBuilder;

class TransactionRepository extends DB
{
    private QueryBuilder $queryBuilder;

    public function __construct(DB $db)
    {
        parent::__construct($db);
        $this->queryBuilder = new queryBuilder($db);
    }

    public function save(array $transactions): void
    {
        $this->queryBuilder->insert('transactions', $transactions);
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

