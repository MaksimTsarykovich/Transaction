<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Connection;
use App\Controller;
use App\Database\DB;
use App\Router;
use App\Controllers\FileController;
use App\Controllers\TransactionController;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use function DI\get;

require_once __DIR__ . '/../vendor/autoload.php';

const STORAGE_PATH = __DIR__ . '/../storage';
const VIEW_PATH = __DIR__ . '/../views';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$containerBuilder = new DI\ContainerBuilder();

$containerBuilder->addDefinitions([
    Config::class => function (ContainerInterface $c) {
        return new Config($_ENV);
    },
    DB::class => function (ContainerInterface $c) {
        return new DB($c->get(Config::class));
    },
    EntityManager::class => function (ContainerInterface $c) {
        $paths = [__DIR__ . '/src/Entity'];
        $isDevMode = true;
        $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
        $db = $c->get(DB::class);
        $connection = $db->getConnection();
    return new EntityManager($connection, $config);
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
