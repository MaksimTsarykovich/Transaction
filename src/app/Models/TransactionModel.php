<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use App\DB;

class TransactionModel extends Model
{
    protected ?string $income;
    protected ?string $net;
    protected ?string $expense;
    protected array $transactions = [];

    public function __construct(DB $db)
    {
        parent::__construct($db);
    }

    public function getAllTransactionFromCvs(string $fileName): TransactionModel
    {
        $this->insertCsvRowsToDatabase($fileName);
        $this->getAllTransactionFromDatabase();
        $this->calculateIncome();
        $this->calculateExpense();
        $this->calculateNet();
        return $this;
    }

    protected function getAllTransactionFromDatabase(): TransactionModel
    {
        $stmt = $this->db->prepare("SELECT * FROM `transactions`");
        $stmt->execute();
        $this->transactions = array_map([$this, 'formatAmountToFloat'], $stmt->fetchAll());

        return $this;
    }

    protected function extractCsvData($fileName): \Generator
    {
        $handle = fopen($fileName, 'r');
        $headers = fgetcsv($handle, null, ",");

        while (($data = fgetcsv($handle, null, ",")) !== false) {
            $rowData = array_combine($headers, $data);
            $rowData['Amount'] = $this->formatAmountToInt($rowData['Amount']);
            yield $rowData;
        }
        fclose($handle);
    }

    protected function insertCsvRowsToDatabase($fileName): void
    {
        $stmt = $this->prepareInsertStatement();
        try {
            $this->db->beginTransaction();
            foreach ($this->extractCsvData($fileName) as $row) {
                $this->insertRow($stmt, $row);
            }
            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();

        }
    }

    protected function prepareInsertStatement(): \PDOStatement|bool
    {
        return $this->db->prepare("INSERT INTO `transactions`(`data`, `check`, `description`, `amount`) VALUES (:data, :check, :description, :amount)");
    }

    protected function insertRow($stmt, $row): \PDOStatement|bool
    {
        return $stmt->execute([
            ':data' => $row['Date'],
            ':check' => $row['Check #'],
            ':description' => $row['Description'],
            ':amount' => $row['Amount'],
        ]);
    }

    protected function formatAmountToInt($value): string
    {
        return str_replace(['$', ',', '.'], '', $value);
    }

    protected function formatAmountToFloat(array|string $transactions): string
    {
        is_array($transactions) ? $amount = $transactions['amount'] : $amount = $transactions;
        return '$' . number_format($amount / 100, 2, '.', ',');
    }

    protected function calculateNet(): TransactionModel
    {
        $stmt = $this->db->prepare("SELECT SUM(`amount`) AS net_total FROM transactions;");
        $stmt->execute();
        $this->net = $this->formatAmountToFloat($stmt->fetchColumn());
        return $this;
    }

    protected function calculateExpense(): TransactionModel
    {
        $stmt = $this->db->prepare("SELECT SUM(amount) AS expense_total FROM transactions WHERE amount < 0");
        $stmt->execute();
        $this->expense = $this->formatAmountToFloat($stmt->fetchColumn());
        return $this;
    }

    protected function calculateIncome(): TransactionModel
    {
        $stmt = $this->db->prepare("SELECT SUM(amount) AS income_total FROM transactions WHERE amount > 0;");
        $stmt->execute();
        $this->income = $this->formatAmountToFloat($stmt->fetchColumn());
        return $this;
    }

    public function toArray(): array
    {
        return [
            'income' => $this->income,
            'expense' => $this->expense,
            'net' => $this->net,
            'transactions' => $this->transactions,
        ];
    }

}
