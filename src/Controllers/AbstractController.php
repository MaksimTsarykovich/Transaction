<?php

declare(strict_types=1);

namespace src\Controllers;

use Core\View;
use FlashMessage;
use JetBrains\PhpStorm\NoReturn;

class  AbstractController
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