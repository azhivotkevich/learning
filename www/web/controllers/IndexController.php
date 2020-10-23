<?php


namespace web\controllers;


use components\SecuredWebController;

class IndexController extends SecuredWebController
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