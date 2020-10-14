<?php


namespace components;


use helpers\Arrays;

class ValidationResult
{
    private array $errors = [];
    private array $fields = [];
    private bool $isValid = true;

    public function addError(string $key, string $error): void
    {
        if (array_key_exists($key, $this->errors)) {
            $this->errors[$key][] = $error;
        } else {
            $this->errors[$key] = [$error];
        }
        $this->isValid = false;

        if (array_key_exists($key, $this->fields)) {
            unset($this->fields[$key]);
        }
    }
    public function addField(string $key, $value): void
    {
        if (array_key_exists($key, $this->errors)) {
            return;
        }
        $this->fields[$key] = $value;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getValue(string $key, $default = null)
    {
        return Arrays::getValue($key, $this->fields, $default);
    }

    public function getErrors(string $key)
    {
        return Arrays::getValue($key, $this->errors, []);
    }

}