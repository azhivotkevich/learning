<?php


namespace components\builder\where;


class Equals extends AbstractCondition
{
    public const OPERATORS = [
        "LIKE",
        ">",
        "<",
        "<>",
        "!=",
        "=",
        ">=",
        "<=",
    ];
    protected function validate(): void
    {
        $isValid = count($this->condition) === 3
            && is_string($this->condition[0])
            && in_array($this->condition[1], self::OPERATORS, true)
            && (is_string($this->condition[2]) || is_numeric($this->condition[2]));
        if (!$isValid) {
            throw new \Exception('Condition is invalid');
        }

    }

    public function getSql(): string
    {
        return "`{$this->condition[0]}` {$this->condition[1]} :{$this->uid}_{$this->condition[0]}";
    }

    public function getBinds(): array
    {
        return [
            ":{$this->uid}_{$this->condition[0]}" => $this->condition[2]
        ];
    }
}