<?php


namespace components\builder;

use helpers\Strings;
use components\App;
use PDO;

class Select
{
    private string $rows = '*';
    private ?string $table = null;
    private ?Where $where;

    public function __construct(array $rows)
    {
        $this->setRows($rows);
    }

    private function setRows(array $rows)
    {
        $rows = array_filter($rows);

        if (empty($rows)) {
            return $this;
        }

        $rows = array_map([Strings::class, 'removeSpecialChars'], $rows);
        $this->rows = implode(',', $rows);

        return $this;
    }

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

    private function execute()
    {
        $db = App::get()->dbConnection();
        $sql = "SELECT {$this->rows} FROM {$this->table} WHERE {$this->where->getSql()}";
        $sth = $db->prepare($sql);
        $sth->execute($this->where->getBinds());

        return $sth;
    }

    public function all()
    {
        var_dump($this->execute()->fetchAll(PDO::FETCH_ASSOC));
    }

    public function one()
    {
        var_dump($this->execute()->fetch(PDO::FETCH_ASSOC));
    }




    /*private string $rows = '*';
    private array $params = [];

    public function where(string $row, string $condition, string $value, string $sqlCondition = ''): Select
    {
        $row = Strings::removeSpecialChars($row);

        if (array_key_exists(":{$row}", $this->params)) {
            $placeholder = count($this->params) . '_' . $row;
        } else {
            $placeholder = $row;
        }

        $sqlCondition = Strings::removeSpecialChars($sqlCondition);
        $this->where[] = "{$sqlCondition} `{$row}` {$condition} :{$placeholder}";

        $this->params[":{$placeholder}"] = $value;
        return $this;
    }

    public function execute(string $fetchMode = PDO::FETCH_COLUMN)
    {
        $sql = "SELECT {$this->rows} FROM {$this->from}";
        if ($this->where) {
            $conditions = implode(' ', $this->where);
            $sql .= " WHERE {$conditions}";
        }

        $sth = $this->db->prepare($sql);
        $sth->execute($this->params);
        return $sth->fetchAll($fetchMode);
    }


    public function rows(array $rows): Select
    {
        $rows = array_filter($rows);

        if (empty($rows)) {
            return $this;
        }

        $rows = array_map([Strings::class, 'removeSpecialChars'], $rows);
        $this->rows = implode(',', $rows);

        return $this;
    }*/
}