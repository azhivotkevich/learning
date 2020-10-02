<?php


namespace components;


use helpers\Arrays;

class Config
{
    private static ?Config $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private array $config = [];

    public function setConfig(array $config = []): self
    {
        $this->config = array_merge($this->config, $config);
        return $this;
    }

    public function get($key, $default = null)
    {
        return Arrays::getValue($key, $this->config, $default);
    }
}