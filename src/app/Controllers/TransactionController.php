<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Models\TransactionModel;
use App\View;

class TransactionController
{
    public function transactions(): View
    {
        $transactions [] = (new TransactionModel(App::db()))
            ->getAllTransactionFromCvs(STORAGE_PATH . '/transactions_sample.csv')
            ->toArray();

        echo '<pre>';
        print_r($transactions);
        echo '</pre>';

        return View::make('transactions', $transactions);
    }

}