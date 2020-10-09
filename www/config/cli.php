<?php
return [
    'controllerNamespace' => '\\cli\\controllers\\',
    'defaultPart'    => 'index',
    'dispatcher'     => \cli\components\Dispatcher::class,
    'migrationsDir'     => __DIR__ . '/../migrations/',
    'db' => require_once __DIR__ . '/db.php',
];