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
        $className = $this->prepareController();

        if (!class_exists($className)) {
            throw new \Exception("Class {$className} can't be load");
        }

        $class = new $className();

        if (!$class instanceof ControllerAbstract) {
            throw new \Exception("Class {$className} is invalid!");
        }

        $class->setControllerPath($this->dispatcher->getControllerPart());

        $method = $this->prepareAction();

        if (!method_exists($class, $method)) {
            throw new \Exception("Method {$method} doesn't exist");
        }

        $class->setActionPath($this->dispatcher->getActionPart());

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