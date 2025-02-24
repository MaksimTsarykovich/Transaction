<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\DB;
use App\Database\TransactionRepository;
use App\Exceptions\DateIsIncorrectFormat;
use App\Helpers\Currency;
use App\Helpers\FinanceCalculator;
use App\Helpers\Utils;
use DateTime;

readonly class TransactionProcessor
{
    private TransactionRepository $transactionRepository;
    private FinanceCalculator $financeCalculator;

    public function __construct(
        private CsvFile $csvFile,
        DB              $db,
    )
    {
        $this->transactionRepository = new TransactionRepository($db);
        $this->financeCalculator = new FinanceCalculator();

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

    public function processTransactions(): array
    {
        $transactions = $this->readTransactionsFromCvsFile();
        $processedTransactions = [];
        foreach ($transactions as $transaction) {
            $processedTransactions [] = $this->formatTransaction($transaction);
        }
        $this->transactionRepository->saveAll($processedTransactions);
        $financialSummary = $this->financeCalculator->getTotal();
        $processedTransactions = array_merge($processedTransactions, $financialSummary);
        Utils::dump($processedTransactions);
        $this->formatAmount($processedTransactions);
        return array_merge($processedTransactions, $financialSummary);
    }

    private function formatTransaction(Transaction $transaction): array
    {
        $this->transactionRepository->save($transaction);
        return $transaction->toArray();
    }


}