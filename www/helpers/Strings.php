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

    public static function removeSpecialChars(string $string): string
    {
        $string = trim($string, " \t\n\r\0\x0B/");
        return preg_replace(/** @lang text */ '/[^a-zA-Z0-9_ -]/s', '', $string);
    }
}