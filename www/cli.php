<?php
error_reporting(E_ALL);

use components\Autoloader;
use components\App;
use components\Config;
require_once __DIR__ . '/components/Autoloader.php';
spl_autoload_register([new Autoloader(__DIR__), 'load']);

$config = require_once __DIR__ . '/config/web.php';

App::init($config);