<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controller;
use App\Helpers\Currency;
use App\Models\CsvFile;
use App\Models\TransactionModel;
use App\Models\TransactionProcessor;
use App\View;


class TransactionController extends Controller
{
    public function transactions(): View
    {
        $csvFile = new CsvFile(STORAGE_PATH . '/transactions_sample.csv');
        $transactionProcessor = new TransactionProcessor($csvFile);
        try {
            $transactions = $transactionProcessor->processTransactions();
        }catch (\Exception $e){
            echo $e->getMessage();
        }
        $data = $csvFile->readAsArray();

        return View::make('transactions', ['transactions' => $transactions]);
    }

}