<?php


namespace components;

use PDO;

class DBConnection
{
    private ?PDO $connection = null;

    /**
     * @return PDO
     * @throws \Exception
     */
    public function getConnection(): PDO
    {
        if (null === $this->connection) {
            $this->connection = $this->setConnection();
        }

        return $this->connection;
    }

    /**
     * @return PDO
     * @throws \Exception
     */
    private function setConnection(): PDO
    {
        $name = App::get()->config()->get('db.username');
        $password = App::get()->config()->get('db.password');
        $dbName = App::get()->config()->get('db.dbname');
        $host = App::get()->config()->get('db.host');
        return new PDO("mysql:host={$host};dbname={$dbName}", $name, $password);
    }
}