<?php


namespace components\builder;


use components\App;
use helpers\Strings;

class Update
{
    private array $rows = [];
    private ?string $table = null;
    private ?Where $where;

    public function __construct(string $table)
    {
        $this->table = trim($table);
    }

    public function set(array $rows)
    {
        $rows = array_filter($rows);
        $this->rows = array_map([Strings::class, 'removeSpecialChars'], $rows);

        return $this;
    }

    public function where(array $condition, string $glue = '')
    {
        $this->where = new Where($condition, $glue);
        return $this;
    }

    public function execute()
    {
        $fields = [];
        $binds = [];

        foreach ($this->rows as $key => $value) {
             $bind = ":{$key}";
             $fields[] = "{$key} = {$bind}";
             $binds[$bind] = $value;
        }
        $fieldsString = implode(',', $fields);

        $binds = array_merge($binds, $this->where->getBinds());

        $sql = "UPDATE {$this->table} SET {$fieldsString} WHERE {$this->where->getSql()}";
        $sth = App::get()->dbConnection()->prepare($sql);
        $sth->execute($binds);
    }

}