<?php


namespace components;

use PDO;

abstract class AbstractBuilder
{
    protected PDO $db;
    protected ?string $from = null;
    protected string $where;

    protected function __construct(string $from)
    {
        $this->setTable($from);
        $this->db = App::get()->dbConnection();
    }

    final private function setTable(string $from): self
    {
        if (null === $this->from) {
            $from = trim($from, " \t\n\r\0\x0B/");
            $this->from = "`{$from}`";
        }
        return $this;
    }
}