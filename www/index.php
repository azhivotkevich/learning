<?php
error_reporting(E_ALL);
use components\Autoloader;
use components\Router;

define('DS', DIRECTORY_SEPARATOR);
require_once __DIR__ . '/components/Autoloader.php';
spl_autoload_register([new Autoloader(__DIR__), 'load']);

$dispatcher = new components\Dispatcher();
$router = new components\Router($dispatcher);
$router->run();