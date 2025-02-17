<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Models\TransactionModel;
use App\View;

class TransactionController extends Controller
{
    public function transactions(): View
    {
        try {
            $transactions [] = (new TransactionModel(App::db()))
                ->getAllTransactionFromCvs(STORAGE_PATH . '/transactions_sampl.csv')
                ->toArray();
            $this->flash->set('success', 'Таблица успешно загружена');
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
        return View::make('transactions', $transactions[0]);
    }

}