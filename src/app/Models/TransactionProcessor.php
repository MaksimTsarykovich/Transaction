<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\DB;
use App\Database\TransactionRepository;
use App\Exceptions\DatabaseCompareRowException;
use App\Exceptions\DatabaseInsertException;
use App\Exceptions\DateIsIncorrectFormat;
use App\Exceptions\FileNotFound;
use App\Helpers\FinanceCalculator;
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

    /**
     * @throws DateIsIncorrectFormat
     * @throws FileNotFound
     */
    private function readTransactionsFromCvsFile(): array
    {
        $transactions = [];
        $rows = $this->csvFile->readAsArray();
        array_shift($rows);
        foreach ($rows as $row) {
            $date = $row[0];
            $check = $row[1];
            $description = $row[2];
            $amount = $row[3];

            $transactions [] = new Transaction($this->formatDate($date), $amount, $check, $description);
        }
        return $transactions;
    }

    /**
     * @return array
     * @throws DateIsIncorrectFormat
     * @throws FileNotFound
     * @throws DatabaseCompareRowException
     * @throws DatabaseInsertException
     */
    public function processTransactions(): array
    {
        $transactions = $this->readTransactionsFromCvsFile();
        $processedTransactions = [];
        foreach ($transactions as $transaction) {
            $transactionArray = $transaction->toArray($transaction);

            $this->financeCalculator->calculate($transaction->getCurrency());
            $transactionArray['amount'] = $transaction->getCurrency()->getAmount();
            $this->transactionRepository->save($transactionArray);

            $processedTransactions [] = $transactionArray;
        }
        $financialSummary = $this->financeCalculator->getTotal();

        return [
            'transactions' => $processedTransactions,
            'financialSummary' => $financialSummary,
            ];
    }

    /**
     * @throws DateIsIncorrectFormat
     */
    private function formatDate(string $date): string
    {
        $date = DateTime::createFromFormat('m/d/Y', $date);
        if (!$date) {
            throw new DateIsIncorrectFormat();
        }
        return $date->format('Y-m-d');
    }
}