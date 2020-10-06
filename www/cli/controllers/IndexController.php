<?php


namespace cli\controllers;


use components\ControllerAbstract;

class IndexController extends ControllerAbstract
{
    public function __construct()
    {
//        echo 'IndexController';
    }

    public function actionIndex()
    {
        echo __METHOD__;
    }
}