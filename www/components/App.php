<?php


namespace components;

use Exception;

class App
{
    private static ?App $instance = null;
    private Config $config;

    private function __construct(Config $config)
    {
        $this->config = $config;
    }

    public static function init(Config $config): App
    {
        if (null !== self::$instance) {
            return self::$instance;
        }

        self::$instance = new self($config);
        self::$instance->route();
        return self::$instance;
    }

    private function __clone()
    {
    }

    /**
     * @return App|null
     * @throws Exception
     */

    public static function get()
    {
        if (null === self::$instance) {
            throw new Exception("App has not been initialized");
        }
        return self::$instance;
    }

    public function config()
    {
        return $this->config;
    }

    /**
     * @return array|mixed|null
     * @throws Exception
     */
    private function route(): void
    {
        $dispatcher = $this->getAppType();
        $dispatcher = $this->config->get($dispatcher);
        if (!$dispatcher || !class_exists($dispatcher)) {
            throw new Exception("Dispatcher is invalid!");
        }
        $dispatcher = new $dispatcher();

        if (!$dispatcher instanceof DispatcherAbstract) {
            throw new Exception("Dispatcher instance is invalid!");
        }

        new Router($dispatcher);
    }

    private function getAppType()
    {
        return php_sapi_name() !== 'cli' ? 'dispatcher' : 'cli_dispatcher';
    }


}