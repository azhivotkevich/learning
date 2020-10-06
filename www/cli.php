<?php
error_reporting(E_ALL);

use components\App;

require_once __DIR__ . '/vendor/autoload.php';
App::init(require_once __DIR__ . '/config/cli.php');