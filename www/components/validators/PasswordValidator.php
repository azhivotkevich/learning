<?php


namespace components\validators;


use components\App;

class PasswordValidator extends ValidatorAbstract
{
    private string $hash;

    public function __construct(string $hash, string $error)
    {
        $this->hash = $hash;
        $this->error = $error;
    }

    public function validate($data)
    {
       return password_verify($data, $this->hash);
    }
}