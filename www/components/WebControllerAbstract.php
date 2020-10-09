<?php


namespace components;


use web\components\Template;

abstract class WebControllerAbstract extends ControllerAbstract
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