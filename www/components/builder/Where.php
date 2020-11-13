<?php


namespace components\builder;


use components\Builder;
use components\builder\where\AbstractCondition;
use components\builder\where\Between;
use components\builder\where\Equals;
use components\builder\where\In;
use components\builder\where\Nullable;

class Where
{
    private array $binds = [];
    private string $sql;

    public function __construct(array $conditions, string $glue = '')
    {
        $this->build($conditions, $glue);
    }

    /**
     * @return array
     */
    public function getBinds(): array
    {
        return $this->binds;
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql ?: '1=1';
    }

    private function build(array $conditions, string $glue): void
    {
        $where = [];

        foreach ($conditions as $condition) {
            $whereObject = $this->getBuilder($condition);
            $where[] = $whereObject->getSql();
            $this->binds = array_merge($this->binds, $whereObject->getBinds());
        }

        $this->sql = implode(" {$glue} ", $where);
    }

    private function getBuilder(array $condition): AbstractCondition
    {
        $operator = strtoupper($condition[1]);
        switch ($operator) {
            case 'IN':
            case 'NOT IN':
                return new In($condition);
            case 'IS NOT NULL':
            case 'IS NULL':
                return new Nullable($condition);
            case 'BETWEEN':
            case 'NOT BETWEEN':
                return new Between($condition);
            case 'LIKE':
            case '>':
            case '<':
            case '<>':
            case '!=':
            case '=':
            case '>=':
            case '<=':
                return new Equals($condition);
            default:
                throw new \Exception('Operator is invalid');
        }
    }
}