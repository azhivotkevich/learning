<?php


namespace components\validators;


class StringValidator extends ValidatorAbstract
{
    private int $min;
    private int $max;

    public function __construct(int $min, int $max, string $error)
    {
        $this->min = $min;
        $this->max = $max;
        $this->error = sprintf($error, $min, $max);
    }

    public function validate($data)
    {
        $strLen = strlen($data);
        return is_string($data) && $strLen >= $this->min && $strLen <= $this->max;
    }
}