<?php

require __DIR__ . '/vendor/autoload.php';

use App\Core\Container;
use App\Core\Database;
use App\Core\ExceptionHandler;
use App\Core\Interfaces\DBConnection;
use App\Core\Request;
use App\Core\Router;

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require __DIR__ . '/constant.php';

$container = new Container();

set_exception_handler([ExceptionHandler::class, 'handle']);

$container->bind(DBConnection::class, function () {
    return Database::getInstance();
});
$container->bind(Request::class, function () {
    return new Request();
});

$request =  $container->make(Request::class);

$router = new Router();
require_once __DIR__ . '/routes/route.php';
$router->dispatch($request, $container);