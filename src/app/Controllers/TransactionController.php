<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Helpers\Currency;
use App\Helpers\FlashMessage;
use App\Helpers\Utils;
use App\Models\CsvFile;
use App\Models\TransactionModel;
use App\Models\TransactionProcessor;
use App\View;


class TransactionController extends Controller
{
    public function transactions(): View
    {
        $csvFile = new CsvFile(STORAGE_PATH . '/transactions_sample.csv');
        $transactionProcessor = new TransactionProcessor($csvFile, App::db());

        try {
            $transactions = $transactionProcessor
                ->processTransactions();
        } catch (\Exception $e) {
            $this->handleError($e);
        }
        return View::make('transactions', [
            'transactionsSummary' => $transactions,
            'flash' => $this->flash->set('success', 'Таблица успешно загружена'),
        ]);
    }

}