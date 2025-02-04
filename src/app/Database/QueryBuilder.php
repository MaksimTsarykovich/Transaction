<?php

namespace App\Database;




class QueryBuilder
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
        $sql = "INSERT INTO `$table`(`data`, `check`, `description`, `amount`, `is_positive`) VALUES (:data, :check, :description, :amount, :is_positive)";
        if($this->isRowExist($data['Description'])) return;
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':data' => $data['Date'],
            ':check' => $data['Check #'],
            ':description' => $data['Description'],
            ':amount' => $data['Amount'],
            ':is_positive' => $data['is_positive'],
        ]);
    }

    protected function isRowExist($description): bool
    {
        $sql = "SELECT `description` FROM `transactions` WHERE `description` = :description";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':description' => $description]);
    }



}

