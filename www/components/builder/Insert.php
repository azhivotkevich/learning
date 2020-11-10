<?php


namespace components\builder;


use components\App;
use helpers\Strings;

class Insert
{
    private array $rows = [];
    private ?string $table = null;

    public function __construct(array $rows)
    {
        $this->setRows($rows);
    }

    private function setRows(array $rows)
    {
        $rows = array_filter($rows);
        $this->rows = array_map([Strings::class, 'removeSpecialChars'], $rows);

        return $this;
    }

    public function into(string $table)
    {
        $this->table = trim($table);
        return $this;
    }

    public function execute()
    {
        $columns = array_keys($this->rows);
        $binds = array_map(function ($column) {
            return ":{$column}";
        }, $columns);

        $columnsString = implode(',', $columns);
        $bindString = implode(',', $binds);

        $params = array_combine($binds, array_values($this->rows));

        $sql = "INSERT INTO `{$this->table}` ({$columnsString}) VALUES({$bindString})";
        $sth = App::get()->dbConnection()->prepare($sql);
        $sth->execute($params);
    }


}