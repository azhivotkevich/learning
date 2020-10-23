<?php


namespace web\controllers;


use components\App;
use components\Validator;
use components\validators\StringValidator;
use components\validators\PasswordValidator;
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
        if (Request::isPost()) {
            $user = (new User())->findUser($_POST['username']);
            $hash = ($user && array_key_exists('password', $user)) ? $user['password'] : '';
            $result = (new Validator())->setup($_POST, [
                'password' => [
                    new PasswordValidator($hash, "Username or password is incorrect")
                ]
            ]);


            if ($result->isValid()) {
                App::get()->session()->set('user', $user);
                header('Location: /index');
            } else {
                App::get()->session()->setFlash('login', $result);
                header('Location: /guest/index');
            }
            exit;
        }

        echo $this->render();
        App::get()->dbConnection();
    }

    public function actionRegistration()
    {
        if (Request::isPost()) {
            $result = (new Validator())->setup($_POST, [
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