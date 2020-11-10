<?php


namespace components\builder;


use components\App;
use helpers\Strings;

class Delete
{
    private ?string $table = null;
    private ?Where $where;

    public function from(string $table)
    {
        $table = trim($table);
        $this->table = "`{$table}`";
        return $this;
    }

    public function where(array $condition, string $glue = '')
    {
        $this->where = new Where($condition, $glue);
        return $this;
    }

    public function execute()
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->where->getSql()}";
        $sth = App::get()->dbConnection()->prepare($sql);
        $sth->execute($this->where->getBinds());
    }



}