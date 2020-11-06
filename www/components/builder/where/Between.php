<?php


namespace components\builder\where;


class Between extends AbstractCondition
{
    public const OPERATORS = [
        "BETWEEN",
        "NOT BETWEEN",
    ];

    protected function validate(): void
    {
        $isValid = count($this->condition) === 4
            && is_string($this->condition[0])
            && in_array($this->condition[1], self::OPERATORS, true)
            && (is_string($this->condition[2]) || is_numeric($this->condition[2]))
            && (is_string($this->condition[3]) || is_numeric($this->condition[3]));
        if (!$isValid) {
            throw new \Exception('Condition is invalid');
        }
    }

    public function getSql(): string
    {
        return sprintf(
            '`%s` %s :from_%s_%s AND :to_%s_%s',
            $this->condition[0],
            $this->condition[1],
            $this->uid,
            $this->condition[0],
            $this->uid,
            $this->condition[0]
        );
    }

    public function getBinds(): array
    {
        return [
            ":from_{$this->uid}_{$this->condition[0]}" => $this->condition[2],
            ":to_{$this->uid}_{$this->condition[0]}" => $this->condition[3]
        ];
    }
}