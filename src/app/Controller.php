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
        $this->flash->set('error', 'Ошибка при загрузке таблицы: '. $exception->getMessage());
        return View::make('error',['flash' => $this->flash]);
    }
}