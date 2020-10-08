<?php
return [
    'controllerNamespace' => '\\cli\\controllers\\',
    'defaultPart'    => 'index',
    'dispatcher'     => \cli\components\Dispatcher::class,
    'migrations_dir'     => __DIR__ . '/../migrations/',
    'db' => require_once __DIR__ . '/db.php',
];