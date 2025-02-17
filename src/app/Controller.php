<?php

declare(strict_types=1);

namespace App;

use App\Helpers\FlashMessage;

class  Controller
{
    protected FlashMessage $flash;

    public function __construct() {
        $this->flash = new FlashMessage();
    }

    public function handleError(\Exception $exception): View
    {
        error_log('Ошибка при загрузке транзакций: ' . $exception->getMessage());
        $this->flash->set('Ошибка: ', $exception->getMessage());
        return View::make('error', ['error' => $exception->getMessage()]);
    }
}