<?php


namespace components\builder;

use components\AbstractBuilder;
use helpers\Strings;
use PDO;

class Select extends AbstractBuilder
{
    private ?string $rows = null;
    private ?array $conditions = [];
    private ?array $params = [];

    public function __construct(string $from)
    {
        parent::__construct($from);
        $this->setRows();
    }

    public function where(string $row, string $condition, string $value, string $sqlCondition = null): Select
    {
        $row = Strings::removeSpecialChars($row);

        $placeholder = array_key_exists(":{$row}", $this->params) ? $placeholder = uniqid() . '_' . $row : $row;

        if (null !== $sqlCondition) {
            $sqlCondition = Strings::removeSpecialChars($sqlCondition);
            $condition = ["{$sqlCondition} `{$row}` {$condition} :{$placeholder}"];
        } else {
            $condition = ["`{$row}` {$condition} :{$placeholder}"];
        }


        $this->conditions = array_merge($this->conditions, $condition);
        $this->params = array_merge($this->params, [":{$placeholder}" => $value]);

        $this->where = implode(' ', $this->conditions);

        return $this;
    }

    public function execute(string $fetchMode = PDO::FETCH_COLUMN)
    {
        $sql = "SELECT {$this->rows} FROM {$this->from}";
        if (isset($this->where)) {
            $sql .= " WHERE {$this->where}";
        }

        $sth = $this->db->prepare($sql);
        $sth->execute($this->params);
        return $sth->fetchAll($fetchMode);
    }


    public function rows(string $rows = ''): Select
    {
        $rows = array_filter(explode(',', $rows));
        $string = '';
        if (!empty($rows)) {
            if (count($rows) > 1) {
                foreach ($rows as $row) {
                    $rowName = Strings::removeSpecialChars($row);
                    $string .= "`{$rowName}`,";
                }
                $string = substr($string, 0, -1);
            } else {
                $string = array_shift($rows);
                $string = "`{$string}`";
            }
            $this->rows = $string;
        }

        return $this;
    }

    private function setRows()
    {
        if (null === $this->rows) {
            $this->rows = '*';
        }
        return $this;
    }
}