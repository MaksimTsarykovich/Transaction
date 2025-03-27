<?php

namespace src\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Entities\File;
use src\Exceptions\DatabaseCompareRowException;
use src\Exceptions\DatabaseDeleteException;
use src\Exceptions\DatabaseInsertException;
use src\Infrastructure\Database\DB;

class FileRepository extends EntityRepository
{
    private $fileRepository;

    public function __construct(
        private DB $db,
        private EntityManager $entityManager,
    )
    {
        $this->fileRepository = $this->entityManager->getRepository(File::class);
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

    public function findAll(): array
    {
        return $this->fileRepository->findAll();
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