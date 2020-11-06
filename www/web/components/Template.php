<?php


namespace web\components;


use components\App;
use helpers\Arrays;

class Template
{
    private string $dir;
    private string $layout;
    private array $variables = [];
    private string $content = '';

    public function __construct(?string $dir = null)
    {
        $this->setDir($dir);
        $this->setLayout(App::get()->config()->get('templateLayout'));
    }

    /**
     * @param string|null $dir
     * @throws \Exception
     */
    private function setDir(?string $dir = null): void
    {
        if (!$dir) {
            $dir = App::get()->config()->get('templatePath');
        }

        if (!$dir || !file_exists($dir)) {
            throw new \Exception("There is no {$dir} directory!");
        }

        $this->dir = $dir;
    }

    public function render($view, array $variables = [])
    {
        $this->variables = $variables;

        ob_start();
        require $this->prepareTemplate($view);
        $this->content = ob_get_clean();

        ob_start();
        require $this->prepareTemplate($this->layout);
        return ob_get_clean();
    }

    public function __get(string $key)
    {
        return Arrays::getValue($key, $this->variables);
    }

    private function prepareTemplate(string $template)
    {
        $file = $this->dir . '/' . $template . '.php';
        if (!file_exists($file)) {
            throw new \Exception("View {$template} doesn't exist");
        }

        return $file;
    }

    public function setLayout(string $layout): self
    {
        $this->layout = "layouts/{$layout}";
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}