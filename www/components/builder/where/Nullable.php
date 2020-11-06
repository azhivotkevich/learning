<?php


namespace components\builder\where;


class Nullable extends AbstractCondition
{
    public const OPERATORS = [
        "IS NOT NULL",
        "IS NULL",
    ];

    protected function validate(): void
    {
        $isValid = count($this->condition) === 2
            && is_string($this->condition[0])
            && in_array($this->condition[1], self::OPERATORS, true);
        if (!$isValid) {
            throw new \Exception('Condition is invalid');
        }
    }

    public function getSql(): string
    {
        return "{$this->condition[0]} {$this->condition[1]}";
    }

    public function getBinds(): array
    {
        return [];
    }
}