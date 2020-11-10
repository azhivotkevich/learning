<?php


namespace components;

use components\builder\Delete;
use components\builder\Select;
use components\builder\Insert;
use components\builder\Update;
use PDO;

class Builder
{
    protected PDO $db;

    public static function select(array $rows = [])
    {
        return new Select($rows);
    }

    public static function insert(array $rows)
    {
        return new Insert($rows);
    }

    public static function update(string $table)
    {
        return new Update($table);
    }

    public static function delete()
    {
        return new Delete();
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