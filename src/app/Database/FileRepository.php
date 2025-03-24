<?php

namespace App\Database;

use App\Exceptions\DatabaseCompareRowException;
use App\Exceptions\DatabaseDeleteException;
use App\Exceptions\DatabaseInsertException;
use App\Helpers\QueryBuilder;
use App\Helpers\Utils;

readonly class FileRepository
{


    public function __construct(private QueryBuilder $queryBuilder)
    {
    }

    /**
     * @throws DatabaseCompareRowException
     * @throws DatabaseInsertException
     */
    public function save(string $file): void
    {
        $this->queryBuilder->insert('files', ['name' => $file]);
    }

    public function getAll(): array
    {
        return $this->queryBuilder->selectAll('files');
    }

    /**
     * @throws DatabaseDeleteException
     */
    public function delete(int $id): void
    {
        $this->queryBuilder->delete('files', ['id' => $id]);
    }

    public function get(int $id)
    {
        return $this->queryBuilder->select('files', ['id' => $id]);
    }
}