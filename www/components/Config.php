<?php


namespace components;


use helpers\Arrays;

class Config
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function get($key, $default = null)
    {
        return Arrays::getValue($key, $this->config, $default);
    }
}