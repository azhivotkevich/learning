<?php


namespace cli\controllers;


use components\App;
use components\ControllerAbstract;
use Exception;
use helpers\Dir;
use models\Migrations;

class MigrateController extends ControllerAbstract
{
    private ?string $dir = null;
    private Migrations $model;

    public function __construct()
    {
        $this->model = new Migrations();
        $this->setDir(App::get()->config()->get('migrations_dir'));
    }

    public function actionUp()
    {
        if (empty($this->dir)) {
            throw new Exception("There is no file to execute on {$this->dir}");
        }
        if (!empty($this->prepareFiles())) {
            foreach ($this->prepareFiles() as $file => $path) {
                if ($this->model->execute(file_get_contents($path))) {
                    $this->model->setExecuted($file);
                    echo sprintf("%s executed \r\n", $file);
                }
            }
        } else {
            echo "Everything is up to date! \r\n";
        }

    }

    private function setDir($dir): void
    {
        if (!file_exists($dir)) {
            throw new Exception("There is no dir: {$dir}; on this server! Check your config.");
        }

        $this->dir = $dir;
    }

    private function prepareFiles(): array
    {
        $files = [];
        foreach (Dir::scan($this->dir) as $file) {
            if (in_array($file, $this->getExecutedFiles())) continue;
            $files[$file] = $this->dir . $file;
        }
        return $files;
    }

    private function getExecutedFiles(): array
    {
        $this->model->verifyTable();
        return $this->model->getExecutedFiles(Dir::scan($this->dir));
    }
}