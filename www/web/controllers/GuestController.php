<?php


namespace web\controllers;


use components\App;
use components\WebControllerAbstract;
use helpers\Request;
use models\User;

class GuestController extends WebControllerAbstract
{
    public function __construct()
    {
        parent::__construct();
        $this->template->setLayout('guest');
    }

    public function actionIndex()
    {
        echo $this->render();
        App::get()->dbConnection();
    }

    public function actionRegistration()
    {
        if (Request::isPost()) {
            $userModel = new User();
            $userModel->createUser($_POST['username'], $_POST['password']);
            /*header('Location: /guest');
            exit;*/
        }
        echo $this->render();
    }
}