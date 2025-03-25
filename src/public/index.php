<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Connection;
use App\Controller;
use App\Router;
use App\Controllers\FileController;
use App\Controllers\TransactionController;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
use function DI\get;

require_once __DIR__ . '/../vendor/autoload.php';

const STORAGE_PATH = __DIR__ . '/../storage';
const VIEW_PATH = __DIR__ . '/../views';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$containerBuilder = new DI\ContainerBuilder();

$containerBuilder->addDefinitions([
    Doctrine\DBAL\Connection::class => function (ContainerInterface $container) {
        $connectionParameters = [
            'host' => $_ENV['DB_HOST'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'dbname' => $_ENV['DB_DATABASE'],
            'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
        ];
        return DriverManager::getConnection($connectionParameters);
    },

    DB::class => function (ContainerInterface $container) {
        return new DB($container->get(Doctrine\DBAL\Connection::class));
    },
],
);

$container = $containerBuilder->build();

$router = new Router($container);

$router
    ->get('/', [FileController::class, 'index'])
    ->get('/transactions', [TransactionController::class, 'transactions'])
    ->get('/error', [Controller::class, 'error'])
    ->get('/form-upload', [FileController::class, 'formUpload'])
    ->post('/upload', [FileController::class, 'upload'])
    ->get('/delete', [FileController::class, 'delete']);


(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();
