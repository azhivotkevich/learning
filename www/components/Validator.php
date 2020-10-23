<?php


namespace components;


use components\validators\ValidatorAbstract;

class Validator
{

    public function setup(array $data, array $rules)
    {
        $result = new ValidationResult();

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $rules)) {
                foreach ($rules[$key] as $rule) {
                    /**
                     * @var $rule ValidatorAbstract
                     */

                    if (!$rule->validate($value)) {
                        $result->addError($key, $rule->getError());
                    } else {
                        $result->addField($key, $value);
                    }
                }
            } else {
                $result->addField($key, $value);
            }
        }

        return $result;
    }
}