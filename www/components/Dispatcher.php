<?php


namespace components;

use helpers\Request;

/**
 * Class Dispatcher
 * @package components
 */

class Dispatcher
{
    private array $parts;
    private string $controllerPart = '';
    private string $actionPart = '';
    private string $current_app_type = '';
    private const DEFAULT_PART = 'index';
    private const APP_TYPES = [
        'apache2handler' => 'web',
        'cli' => 'cli'
    ];

    public function dispatch(): void
    {
        $this->defineAppType();
        $setterMethod = "set{$this->current_app_type}Parts";
        $this->{$setterMethod}();
    }

    private function defineAppType(): void
    {
        if ($this->current_app_type) {
            return;
        }
        if (false === array_key_exists(php_sapi_name(), self::APP_TYPES)) {
            $this->current_app_type = 'Web';
        }
        $this->current_app_type = ucwords(self::APP_TYPES[php_sapi_name()]);
    }

    private function parseParts(): void
    {
        if ($this->controllerPart && $this->actionPart) {
            return;
        }

        $this->dispatch();

        $this->controllerPart = $this->parts ? array_shift($this->parts) : self::DEFAULT_PART;
        $this->actionPart = $this->parts ? array_shift($this->parts) : self::DEFAULT_PART;
    }

    /**
     * @return string
     */
    public function getActionPart(): string
    {
        $this->parseParts();
        return $this->actionPart;
    }

    /**
     * @return string
     */
    public function getControllerPart(): string
    {
        $this->parseParts();
        return $this->controllerPart;
    }

    public function getCurrentAppType(): string
    {
        $this->defineAppType();
        return $this->current_app_type;
    }

    protected function setWebParts(): void
    {
        $this->parts = array_filter(explode('/', Request::clearUrl($_SERVER['REQUEST_URI'])));
    }

    private function setCliParts(): void
    {
        $address = $_SERVER['argv'][1] ?? '';
        $this->parts = array_filter(explode('::', trim($address)));
    }
}