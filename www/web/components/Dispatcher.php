<?php


namespace web\components;

use components\App;
use components\DispatcherAbstract;
use helpers\Request;

/**
 * Class Dispatcher
 * @package components
 */
class Dispatcher extends DispatcherAbstract
{
    protected function setParts(): void
    {
        $defaultPart = (string)App::get()->config()->get('defaultPart');
        $part = Request::clearUrl($_SERVER['REQUEST_URI']);
        $part = array_filter(explode('/', $part));

        $this->controllerPart = array_shift($part) ?: $defaultPart;
        $this->actionPart = array_shift($part) ?: $defaultPart;
    }
}