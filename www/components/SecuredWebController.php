<?php


namespace components;


abstract class SecuredWebController extends WebControllerAbstract
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