<?php


namespace components\builder\where;


abstract class AbstractCondition
{
    protected array $condition;
    protected string $uid;

    public function __construct(array $condition)
    {
        $this->uid = uniqid();
        $this->condition = $condition;
        $this->validate();
    }

    abstract public function getSql(): string;

    abstract public function getBinds(): array;

    abstract protected function validate(): void;
}