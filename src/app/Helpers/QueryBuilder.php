<?php

namespace App\Helpers;


use App\Database\DB;
use App\Exceptions\DatabaseCompareRowException;
use App\Exceptions\DatabaseInsertException;
use PDOException;

readonly class QueryBuilder
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function selectAll($table): false|array
    {
        $sql = "SELECT * FROM $table";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @throws DatabaseInsertException
     * @throws DatabaseCompareRowException
     */
    public function insert($table, $data): void
    {

        $keys = '`'.implode('`, `', array_keys($data)) . '`';
        $tags = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO `{$table}` ({$keys}) VALUES ({$tags})";

        if ($this->isRowExist($data['description'])) {
            return;
        }

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $e) {
            throw new DatabaseInsertException();
        }
    }

    /**
     * @throws DatabaseCompareRowException
     */
    protected function isRowExist($description): bool
    {
        $sql = "SELECT COUNT(*) FROM `transactions` WHERE `description` = :description";

        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute(['description' => $description]);
        } catch (PDOException $e) {
            throw new DatabaseCompareRowException();
        }

        return $stmt->fetchColumn() > 0;
    }


}

