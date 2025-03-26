<?php

declare(strict_types=1);

namespace src\Controllers;

use App\Models\TransactionModel;
use Core\App;
use Core\View;
use Domain\Services\csv\TransactionProcessor;
use Infrastructure\FileSystem\CsvFile;


class TransactionController extends AbstractController
{
    public function transactions(): View
    {
        $csvFile = new CsvFile(App::db(),STORAGE_PATH . '/transactions_sample.csv');
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