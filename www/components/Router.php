<?php


namespace components;

use exceptions\NotFoundException;
use helpers\Strings;

/**
 * Class Router
 * @package components
 */
class Router
{
    private Dispatcher $dispatcher;
    private const CONTROLLER_SUFFIX = 'Controller';
    private string $appControllersNamespace = '';

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->setAppControllersNamespace();
    }

    public function run()
    {
        $controller = $this->getControllerObject();
        $action = $this->getActionMethod($controller);

        return $controller->{$action}();
    }

    private function getControllerObject()
    {
        $controller = $this->dispatcher->getControllerPart();
        $class = $this->appControllersNamespace . Strings::camelize($controller) . self::CONTROLLER_SUFFIX;
        if (false === class_exists($class)) {
//            throw new NotFoundException("Class {$class} is undefined");
            die("Class {$class} is undefined");
        }

        $object = new $class();

        if (!$object instanceof ControllerAbstract) {
//            throw new NotFoundException("Object of {$class} has incorrect instance");
            die("Object of {$class} has incorrect instance");
        }

        return $object;
    }

    private function getActionMethod(ControllerAbstract $controller): string
    {
        $action = $this->dispatcher->getActionPart();
        $method = 'action' . Strings::camelize($action);

        if (false === method_exists($controller, $method)) {
            die("Action {$action} is undefined");
        }

        return $method;
    }

    private function setAppControllersNamespace(): void
    {
        $appName = $this->dispatcher->getCurrentAppType();
        $this->appControllersNamespace = "\\{$appName}\\controllers\\";
    }
}