<?php


namespace components\validators;


abstract class ValidatorAbstract
{
    protected string $error = '';

    abstract public function validate($data);

    public function getError()
    {
        return $this->error;
    }
}