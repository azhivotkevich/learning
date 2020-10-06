<?php


namespace web\controllers;


use components\WebControllerAbstract;

class IndexController extends WebControllerAbstract
{
    public function actionIndex()
    {
        echo $this->render();
    }

    public function actionTest()
    {
        echo $this->render();
    }
}