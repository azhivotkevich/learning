<?php


namespace cli\controllers;


use cli\helpers\Colors, components\App, components\ControllerAbstract, Exception, helpers\Dir, models\Migrations;

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
        if (empty($this->dir)) throw new Exception("There is no file to execute on {$this->dir}");

        if (!empty($this->prepareFiles())) {
            foreach ($this->prepareFiles() as $file => $path) {
                if ($this->model->execute(file_get_contents($path))) {
                    $this->model->setExecuted($file);
                    Colors::print("{$file} executed \r\n", 'yellow');
                }
            }
        } else Colors::print("Everything is up to date! \r\n", 'light_purple');

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