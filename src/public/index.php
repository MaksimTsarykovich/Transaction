<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Controller;
use App\Router;
use App\Controllers\HomeController;
use App\Controllers\TransactionController;

require_once __DIR__ . '/../vendor/autoload.php';

const STORAGE_PATH = __DIR__ . '/../storage';
const VIEW_PATH = __DIR__ . '/../views';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$router = new Router();

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/transactions', [TransactionController::class, 'transactions'])
    ->get('/error', [Controller::class,'error'])
    ->post('/upload', [HomeController::class, 'upload']);


(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();
