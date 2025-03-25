<?php

declare(strict_types=1);

namespace App;

use App\Helpers\FlashMessage;
use App\Helpers\Utils;
use JetBrains\PhpStorm\NoReturn;

class  Controller
{
    protected FlashMessage $flash;

    public function __construct()
    {
    }

    public function handleError(\Exception $exception): View
    {
        $this->flash->set('error', 'Ошибка: ' . $exception->getMessage());
        return View::make('error', ['flash' => $this->flash]);
    }

    #[NoReturn] public function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}