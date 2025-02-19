<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\TransactionRepository;
use App\Exceptions\DateIsIncorrectFormat;
use App\Helpers\Currency;
use App\Helpers\Utils;
use DateTime;

class TransactionProcessor
{
    private Currency $currency;
    private TransactionRepository $transactionRepository;

    public function __construct(
        private CsvFile $csvFile,
    )
    {
    }

    public function readTransactionsFromCvsFile(): array
    {
        $transactions = [];
        $rows = $this->csvFile->readAsArray();
        array_shift($rows);
        foreach ($rows as $row) {
            $date = $row[0];
            $check = $row[1];
            $description = $row[2];
            $amount = $row[3];

            $transactions [] = new Transaction($date, $amount, $check, $description);
        }
        return $transactions;
    }

    /**
     * @throws DateIsIncorrectFormat
     */
    public function processTransactions(): array
    {
        $transactions = $this->readTransactionsFromCvsFile();
        $processedTransactions = [];
        foreach ($transactions as $transaction) {
            $processedTransactions [] = $this->formatTransaction($transaction);
        }
        Utils::dump($processedTransactions);
        $processedTransactions = array_merge($processedTransactions, $this->calculateFinancialSummary($processedTransactions));
        $this->transactionRepository->saveAll($processedTransactions);
        return $processedTransactions;
    }

    private function formatTransaction(Transaction $transaction): array
    {
        $this->currency = new Currency($transaction->getAmount());
        $amount = $this->currency->formatToInt($transaction->getAmount());
        return [
            'date' => $this->formatDate($transaction->getDate()),
            'amount' => $amount,
            'check' => $transaction->getCheck(),
            'description' => $transaction->getDescription(),
            'is_positive' => $this->currency->isPositiveAmount($amount),
        ];
    }

    private function calculateFinancialSummary(array $transactions): array
    {
        return array_reduce($transactions, function ($carry, $transaction) {
            if ($transaction['amount'] > 0) {
                $carry['income'] += $transaction['amount'];
            } elseif ($transaction['amount'] < 0) {
                $carry['expense'] += $transaction['amount'];
            }
            $carry['total'] += $transaction['amount'];
            return $carry;
        }, ['income' => 0, 'expense' => 0, 'total' => 0]);
    }

    private function formatDate(string $date): string
    {
        $date = DateTime::createFromFormat('m/d/Y', $date);
        if (!$date) {
            throw new DateIsIncorrectFormat();
        }
        return $date->format('Y-m-d');
    }

}