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

    public function __construct(DispatcherAbstract $dispatcher)
    {
        $this->dispatcher = $dispatcher;
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

        return App::get()->config()->get('controllerNamespace') . $controller . 'Controller';
    }

    private function prepareAction()
    {
        $action = $this->dispatcher->getActionPart();
        $action = Strings::camelize($action);

        return 'action' . $action;
    }


}