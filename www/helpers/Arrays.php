<?php


namespace helpers;

/**
 * Class Arrays
 * @package helpers
 */

class Arrays
{
    public static function getValue($key, array $array, $default = null)
    {
        $parts = explode('.', $key);
        foreach ($parts as $part) {
            if (is_array($array) && array_key_exists($part, $array)) {
                $array = $array[$part];
            } else {
                return $default;
            }
        }

        return $array;
    }
}