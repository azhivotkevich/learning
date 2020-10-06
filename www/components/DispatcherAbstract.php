<?php


namespace components;

use helpers\Request;

abstract class DispatcherAbstract
{
    protected string $controllerPart = '';
    protected string $actionPart = '';

    public function __construct()
    {
        $this->setParts();
    }

    public function getControllerPart(): string
    {
        return $this->controllerPart;
    }

    public function getActionPart(): string
    {
        return $this->actionPart;
    }

    protected function setParts(): void
    {
    }
}