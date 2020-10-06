<?php


namespace components;

use PDO;

class ModelAbstract
{
    public function db(): PDO
    {
        return App::get()->dbConnection();
    }
}