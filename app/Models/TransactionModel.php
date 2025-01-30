<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use App\DB;

class TransactionModel extends Model
{
    protected array $data = [];

    public function __construct(DB $db)
    {
        parent::__construct($db);
    }

    protected function extractCsvData($fileName)
    {
        $data = [];
        $handle = fopen($fileName, 'r');
        $headers = fgetcsv($handle, null, ",");

        while (($data = fgetcsv($handle, null, ",")) !== false) {
            yield array_combine($headers, $data);
        }
        fclose($handle);
    }

    protected function insertCsvRowsToDatabase($fileName)
    {
        $stmt = $this->db->prepare("INSERT INTO `transactions`(`data`, `check`, `description`, `amount`) VALUES (:data, :check, :description, :amount)");
        foreach ($this->extractCsvData($fileName) as $row) {
            $stmt->execute([
                ':data' => $row['data'],
                ':check' => $row['check'],
                ':description' => $row['description'],
                ':amount' => $row['amount'],
            ]);
        }
    }

    
}
