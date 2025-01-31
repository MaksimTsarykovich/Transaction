<?php 

declare(strict_types = 1);

namespace App\Controllers;

use App\App;
use App\Models\TransactionModel;
use App\View;

class TransactionController
{
    public function transactions(): View
    {
        $transactions = (new TransactionModel(App::db()))->getAllTransactionFromCvs('transactions_sample.csv');
        return View::make('transactions', $transactions);
    }
}