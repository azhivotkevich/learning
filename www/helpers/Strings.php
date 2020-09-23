<?php


namespace helpers;


class Strings
{
    /**
     * @param string $string
     * @return string
     */
    public static function camelize(string $string): string
    {
        return str_replace('-', '', ucwords($string, '-'));
    }

    /**
     * @param string $string
     * @return string
     */
    public static function decamelize(string $string): string
    {
        $string = preg_replace('/([a-z])([A-Z])/', "\\1-\\2", $string);
        return strtolower($string);
    }
}