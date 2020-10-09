<?php


namespace cli\controllers;


use cli\helpers\Colors, components\App, components\ControllerAbstract, Exception, helpers\Dir, models\Migrations;

class MigrateController extends ControllerAbstract
{
    private Migrations $model;

    public function __construct()
    {
        $this->model = new Migrations();
        $this->model->createMigrationsTable();
    }

    public function actionUp()
    {
        $newMigrations = $this->model->getNewMigrations();
        if (!$newMigrations) {
            Colors::print("There is no new migrations \r\n", "cyan");
        }

        foreach ($newMigrations as $newMigration) {
            if ($this->model->executeMigration($newMigration)) {
                $this->model->saveMigrationStatus($newMigration);
                Colors::print("File {$newMigration} executed \r\n", "green");
            } else {
                Colors::print("File {$newMigration} hasn't been executed \r\n", "red");
            }
        }
    }


}