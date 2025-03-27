<?php

declare(strict_types=1);

namespace src\Controllers;

use App\Models\TransactionModel;
use Core\App;
use Core\View;
use Domain\Services\csv\TransactionProcessor;
use Infrastructure\FileSystem\CsvFile;
use src\Attributes\Get;
use src\Repository\FileRepository;


class TransactionController extends AbstractController
{
    #[Get('/transaction')]
    public function transactions(): View
    {
        $this->fileRepository = new FileRepository();
        $this->fileRepository->getFileById();


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