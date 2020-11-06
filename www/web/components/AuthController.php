<?php


namespace web\components;

use components\App;

abstract class AuthController extends ControllerAbstract
{
    public function __construct()
    {
        parent::__construct();
        if (!App::get()->session()->get('user')) {
            header("Location: /guest");
            exit();
        }
    }
}