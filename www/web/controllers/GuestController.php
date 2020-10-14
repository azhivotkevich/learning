<?php


namespace web\controllers;


use components\App;
use components\Validator;
use components\validators\StringValidator;
use components\validators\UniqueValidator;
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
            $result = (new Validator())->validate($_POST, [
                'username' => [
                    new StringValidator(4, 14, "Field should be min %s and max %s"),
                    new UniqueValidator('users', 'name', "Name %s is already exist")
                ],
                'password' => [
                    new StringValidator(7, 14, "Field should be min %s and max %s")
                ]
            ]);

            if ($result->isValid()) {
                $userModel = new User();
                $userModel->createUser($result->getValue('username'), $result->getValue('password'));
                header('Location: /guest');
            } else {
                App::get()->session()->setFlash('registration', $result);
                header('Location: /guest/registration');
            }
            exit;
        }
        echo $this->render(['result' => App::get()->session()->getFlash('registration')]);
    }
}