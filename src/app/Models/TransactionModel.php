<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\QueryBuilder;
use App\Model;
use App\Database\DB;
use Exception;
use Generator;

class TransactionModel extends Model
{
    protected ?string $income;
    protected ?string $net;
    protected ?string $expense;
    protected array $transactions = [];
    protected QueryBuilder $queryBuilder;

    public function __construct(DB $db)
    {
        parent::__construct($db);
        $this->queryBuilder = new QueryBuilder($db);
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
        $transactions = $this->queryBuilder->selectAll('transactions');

        $this->transactions = array_map([$this, 'formatAmountToString'], $transactions);

        return $this;
    }

    protected function extractCsvData($fileName): Generator
    {
        $handle = fopen($fileName, 'r');
        $headers = fgetcsv($handle);

        while (($data = fgetcsv($handle)) !== false) {
            $rowData = array_combine($headers, $data);
            yield $rowData;
        }

        fclose($handle);
    }

    protected function insertCsvRowsToDatabase($fileName): void
    {
        try {
            $this->db->beginTransaction();
            foreach ($this->extractCsvData($fileName) as $row) {
                $row = $this->formatTransactionAmount($row);
                $this->queryBuilder->insert('transactions', $row);
            }
            $this->db->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }


    protected function formatTransactionAmount(array $row): array
    {
        $row['Amount'] = $this->formatAmountToInt($row['Amount']);
        $row['Amount'] > 0 ? $row['is_positive'] = 1 : $row['is_positive'] = 0;
        return $row;
    }

    protected function formatAmountToInt($value): int
    {
        $value = str_replace(['$', ',', '.'], '', $value);
        return (int)$value;
    }

    protected function formatAmountToString(array|string $value): array|string
    {
        if (is_array($value)) {
            $value['amount'] = number_format($value['amount'] / 100, 2);
            return $value;
        }
        return number_format($value / 100, 2);
    }

    protected function calculateNet(): TransactionModel
    {
        $sql = "SELECT SUM(`amount`) AS net_total FROM transactions;";
        $this->calculate($sql, $this->net);
        return $this;
    }

    protected function calculateExpense(): TransactionModel
    {
        $sql = "SELECT SUM(amount) AS expense_total FROM transactions WHERE amount < 0;";
        $this->calculate($sql, $this->expense);
        return $this;
    }

    protected function calculateIncome(): TransactionModel
    {
        $sql = "SELECT SUM(amount) AS income_total FROM transactions WHERE amount > 0;";
        $this->calculate($sql, $this->income);
        return $this;
    }

    protected function calculate(string $sql, null|string &$filed): TransactionModel
    {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $filed = $this->formatAmountToString($stmt->fetchColumn());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $this;
    }

    public
    function toArray(): array
    {
        return [
            'income' => $this->income,
            'expense' => $this->expense,
            'net' => $this->net,
            'transactions' => $this->transactions,
        ];
    }

}
