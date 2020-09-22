<?php


namespace components;

use helpers\Request;

/**
 * Class Router
 * @package components
 */
class Router
{
    /**
     * @var string
     */
    private $url;

    /**
     * Router constructor.
     * @param $url
     * @param string $delimiter
     */

    public function __construct($url, $delimiter = '/')
    {
        $this->url = Request::clearUrl($url);
        return $this->dispatch($delimiter);
    }

    /**
     * @param $delimiter
     * @return string
     */

    private function dispatch($delimiter)
    {
        $controllerNamespace = ($delimiter !== '::') ? 'web\controllers\\' : 'cli\controllers\\';
        $parts = array_filter(explode($delimiter, $this->url));
        $controllerName = $controllerNamespace . ucfirst(strtolower(array_shift($parts) ?? 'index')) . 'Controller';

        if (false === class_exists($controllerName)) {
            die("{$controllerName} doesn't exist");
        }

        $controllerObject = new $controllerName;

        $action = ucfirst(strtolower(array_shift($parts) ?? 'index'));

        if (false === method_exists($controllerObject, $action)) {
            die("There is no {$action} action");
        }

        return $controllerObject->{$action}();
    }
}