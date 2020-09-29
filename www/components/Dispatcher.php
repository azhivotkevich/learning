<?php


namespace components;

use helpers\AppType;
use helpers\Request;

/**
 * Class Dispatcher
 * @package components
 */
class Dispatcher
{
    private string $controllerPart = '';
    private string $actionPart = '';
    private const DEFAULT = 'index';

    public function __construct()
    {
        $this->setPart();
    }

    public function getControllerPart(): string
    {
        return $this->controllerPart;
    }

    public function getActionPart(): string
    {
        return $this->actionPart;
    }

    private function setPart(): void
    {
        $paths = Request::clearUrl($_SERVER['REQUEST_URI']);
        $paths = array_filter(explode('/', $paths));

        $this->controllerPart = array_shift($paths) ?: self::DEFAULT;
        $this->actionPart = array_shift($paths) ?: self::DEFAULT;
    }
}