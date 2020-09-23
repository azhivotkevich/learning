<?php


namespace cli\controllers;


use components\ControllerAbstract;

class IndexController extends ControllerAbstract
{
    public function __construct()
    {
        echo 'IndexController';
    }

    public function Index()
    {
        echo __METHOD__;
    }
}