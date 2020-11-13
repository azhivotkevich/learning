<?php


namespace web\controllers;

use components\Builder;
use models\User;
use web\components\AuthController;

class IndexController extends AuthController
{
    public function actionIndex()
    {
        echo $this->render();
    }

    public function actionTest()
    {
        $users = User::findOne([['id','=','2']]);
        $users->name = 'ggg';
        $users->save();
//        Builder::insert(['name' => rand()])->into('contact_types')->execute();
        /*Builder::update('contact_types')->set(['name' => date('H:i:s')])->where([
            ['id', '=', '1']
        ])->execute();*/
//        Builder::delete()->from('users')->where([['name','=','sssssss']])->execute();
        echo $this->render();
    }
}