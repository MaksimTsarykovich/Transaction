<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\DateIsIncorrectFormat;
use DateTime;

class TransactionProcessor
{
    private CsvFile $csvFile;

    public function __construct(CsvFile $csvFile)
    {
        $this->csvFile = $csvFile;
    }

    public function getTransactions(): array
    {
        $transactions = [];
        foreach ($this->csvFile->readAsArray() as $row) {
            $date = $row[0];
            $check = $row[1];
            $description = $row[2];
            $amount = $row[3];

            $transactions [] = new Transaction($date, $amount, $check, $description);
        }
        return $transactions;
    }

    public function processTransactions(): array
    {
        $transactions = $this->getTransactions();
        $processedTransactions = [];
        foreach ($transactions as $transaction) {
            $processedTransactions [] = [
                'date' => $this->formatDate($transaction->getDate),
                'amount' => $this->formatAmount($transaction->getAmount),
                'check' => $transaction->getCheck(),
                'description' => $transaction->getDescription(),
                'is_positive' => $this->isPositive($transaction->getAmount),
            ];
        }
        return $processedTransactions;
    }


    private function formatDate(string $date): string
    {
        $date = DateTime::createFromFormat('m/d/Y', $date);
        if (!$date) {
            throw new DateIsIncorrectFormat();
        }
        return $date->format('Y-m-d');
    }

    protected function isPositive($amount): int
    {
        return $amount > 0 ? 1 : 0;
    }

    protected function formatAmount($value): int
    {
        $value = str_replace(['$', ',', '.'], '', $value);
        return (int)$value;
    }


}