<?php

use components\Autoloader;
use components\Router;

define('DS', DIRECTORY_SEPARATOR);
require_once __DIR__ . '/components/Autoloader.php';
spl_autoload_register([new Autoloader(__DIR__), 'load']);

(new Router($_SERVER['REQUEST_URI'], '::'));