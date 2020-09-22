<?php


namespace components;


class Autoloader
{
    private $baseDir = null;

    public function __construct($baseDir = null)
    {
        $this->baseDir = $baseDir ?: __DIR__;
    }

    /**
     * @param $class
     * @throws \Exception
     */

    public function load($class)
    {
        $file = $this->baseDir . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        if (false === file_exists($file)) {
            throw new \Exception("Class {$class} can't be loaded");
        }
        require_once $file;
    }
}