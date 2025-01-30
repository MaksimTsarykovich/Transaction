<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Router;
use App\Controllers\HomeController;

require_once __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../storage');

$router = new Router();

$router
    ->get('/',[HomeController::class, 'index']);
    ->get('/',[TransactionController::class, 'index']);

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
)) ->run();