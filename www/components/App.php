<?php


namespace components;

use Exception;
use PDO;

class App
{
    private static ?App $instance = null;
    private Config $config;

    private function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    public static function init(array $config): App
    {
        if (null === self::$instance) {
            self::$instance = new self($config);
        }
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
        $dispatcherClass = $this->config->get('dispatcher');
        if (!$dispatcherClass || !class_exists($dispatcherClass)) {
            throw new Exception("Dispatcher is invalid!");
        }


        /** @var DispatcherAbstract $dispatcher */
        $dispatcher = new $dispatcherClass();

        if (!$dispatcher instanceof DispatcherAbstract) {
            throw new Exception("Dispatcher instance is invalid!");
        }

        new Router($dispatcher);
    }

    private ?DBConnection $db = null;

    public function dbConnection(): PDO
    {
        if (null === $this->db) {
            $this->db = new DBConnection();
        }
        return $this->db->getConnection();
    }
}