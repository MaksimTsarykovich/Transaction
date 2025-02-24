<?php

namespace App\Helpers;


use App\Database\DB;
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
            echo 'Error: ' . $e->getMessage();
        }
    }

    protected function isRowExist($description): bool
    {
        $sql = "SELECT COUNT(*) FROM `transactions` WHERE `description` = :description";

        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute(['description' => $description]);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        return $stmt->fetchColumn() > 0;
    }


}

