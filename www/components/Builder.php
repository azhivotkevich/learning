<?php


namespace components;

use PDO;

class Builder
{
    protected PDO $db;

    public static function select(array $rows = [])
    {
        return new \components\builder\Select($rows);
    }




    /*protected ?string $from = null;
    protected array $where;

    public function __construct(string $from)
    {
        $this->setTable($from);
        $this->db = App::get()->dbConnection();
    }

    final private function setTable(string $from): self
    {
        if (null === $this->from) {
            $from = trim($from);
            $this->from = "`{$from}`";
        }
        return $this;
    }*/
}