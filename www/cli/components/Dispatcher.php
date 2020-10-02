<?php


namespace cli\components;

use components\App;
use components\DispatcherAbstract;

/**
 * Class Dispatcher
 * @package components
 */
class Dispatcher extends DispatcherAbstract
{
    protected function setParts(): void
    {
        $defaultPart = (string)App::get()->config()->get('defaultPart');
        $part = $_SERVER['argv'];
        $part = array_filter(explode('::', $part[1]));

        $this->controllerPart = array_shift($part) ?: $defaultPart;
        $this->actionPart = array_shift($part) ?: $defaultPart;
    }
}