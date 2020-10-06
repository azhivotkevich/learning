<?php
return [
    'controllerNamespace' => '\\web\\controllers\\',
    'defaultPart' => 'index',
    'dispatcher' => \web\components\Dispatcher::class,
    'templatePath' => __DIR__ . '/../web/view',
    'templateLayout' => 'main',
    'db' => require_once __DIR__ . '/db.php',
];