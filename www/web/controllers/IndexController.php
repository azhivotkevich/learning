<?php


namespace web\controllers;

use web\components\AuthController;

class IndexController extends AuthController
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