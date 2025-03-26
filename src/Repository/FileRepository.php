<?php

namespace src\Repository;

use Infrastructure\Database\DB;
use src\Exceptions\DatabaseCompareRowException;
use src\Exceptions\DatabaseDeleteException;
use src\Exceptions\DatabaseInsertException;

readonly class FileRepository
{


    public function __construct(private DB $db)
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
        return $this->db->queryBuilder
            ->select('*')
            ->from('files')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * @throws DatabaseDeleteException
     */
    public function delete(int $id)
    {
        return $this->db->queryBuilder
            ->delete('files')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeStatement();
    }

    public function get(int $id)
    {
        return $this->queryBuilder->select('files', ['id' => $id]);
    }
}