<?php
error_reporting(E_ALL);

use components\Autoloader;
require_once __DIR__ . '/components/Autoloader.php';
spl_autoload_register([new Autoloader(__DIR__), 'load']);

$config = require_once __DIR__ . '/config/main.php';

$dispatcher = new \components\Dispatcher();
$router = new \components\Router($dispatcher);

var_dump($router);