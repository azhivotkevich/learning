<?php


namespace helpers;


class AppType
{
    public static function getType(array $appTypes)
    {
        return array_key_exists(php_sapi_name(), $appTypes)
            ? Arrays::getValue(php_sapi_name(), $appTypes)
            : Arrays::getValue('default', $appTypes);
    }
}