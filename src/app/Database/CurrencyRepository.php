<?php

namespace App\Database;

use App\Helpers\QueryBuilder;

readonly class CurrencyRepository extends DB
{
    private QueryBuilder $queryBuilder;

    public function __construct(DB $conn)
    {
        $this->queryBuilder = $conn->createQueryBuilder();
    }

    public function save(array $currency): void
    {
        $this->queryBuilder->insert('currency', $currency);
    }

    public function saveAll(array $currencies): void
    {
        foreach ($currencies as $currency) {
            $this->save($currency);
        }
    }

    public function getAll(): array {
        return $this->queryBuilder->selectAll('transactions');
    }
}