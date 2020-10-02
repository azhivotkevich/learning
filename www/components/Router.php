<?php


namespace components;

use helpers\Strings;

/**
 * Class Router
 * @package components
 */
class Router
{
    private DispatcherAbstract $dispatcher;
    private const CONTROLLER_NAMESPACE = '\\web\\controllers\\';

    public function __construct($dispatcher)
    {
        $this->dispatcher = $dispatcher instanceof DispatcherAbstract ? $dispatcher : null;
        $this->run();
    }

    private function run()
    {
        $class = $this->prepareController();

        if (!class_exists($class)) {
            throw new \Exception("Class {$class} can't be load");
        }

        $class = new $class();

        if (!$class instanceof ControllerAbstract) {
            throw new \Exception("Class {$class} is invalid!");
        }

        $method = $this->prepareAction();

        if (!method_exists($class, $method)) {
            throw new \Exception("Method {$method} doesn't exist");
        }

        return $class->{$method}();
    }

    private function prepareController()
    {
        $controller = $this->dispatcher->getControllerPart();
        $controller = Strings::camelize($controller);

        return self::CONTROLLER_NAMESPACE . $controller . 'Controller';
    }

    private function prepareAction()
    {
        $action = $this->dispatcher->getActionPart();
        $action = Strings::camelize($action);

        return 'action' . $action;
    }


}