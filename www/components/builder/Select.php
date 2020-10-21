<?php


namespace components\builder;

use components\AbstractBuilder;
use helpers\Strings;
use PDO;

class Select extends AbstractBuilder
{
    private string $rows = '*';
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
    }
}