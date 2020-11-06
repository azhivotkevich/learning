<?php


namespace components\builder\where;


class In extends AbstractCondition
{
    public const OPERATORS = [
        "IN",
        "NOT IN",
    ];

    protected function validate(): void
    {
        $isValid = count($this->condition) === 3
            && is_string($this->condition[0])
            && in_array($this->condition[1], self::OPERATORS, true)
            && is_array($this->condition[2])
            && array_filter($this->condition[2], static function ($item) {
                return is_string($item) || is_numeric($item);
            });
        if (!$isValid) {
            throw new \Exception('Condition is invalid');
        }
    }

    public function getSql(): string
    {
        return "{$this->condition[0]} {$this->condition[1]} (:{$this->uid}_{$this->condition[0]})";
    }

    public function getBinds(): array
    {
        return [
            ":{$this->uid}_{$this->condition[0]}" => implode(',', $this->condition[2])
        ];
    }
}