<?php


namespace web\components;

use components\ControllerAbstract as BaseController;

abstract class ControllerAbstract extends BaseController
{
    protected Template $template;

    public function __construct()
    {
        $this->template = new Template();
    }

    protected function render(array $variables = [])
    {
        return $this->template->render("{$this->getControllerPath()}/{$this->getActionPath()}", $variables);
    }
}