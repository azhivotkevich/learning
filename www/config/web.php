<?php
return [
    'controllerNamespace' => '\\web\\controllers\\',
    'defaultPart'    => 'index',
    'dispatcher'     => \web\components\Dispatcher::class,
    'templatePath'     => __DIR__ . '/../web/view',
    'templateLayout'     => 'layouts/main',
];