<?php


namespace helpers;


class Request
{
    public static function clearUrl($url)
    {
        $url = trim(urldecode($url), " \t\n\r\0\x0B/");
        $getParamsStart = strpos($url, '?');
        if (false !== $getParamsStart) {
            $url = substr($url, 0, $getParamsStart);
        }

        return $url;
    }

    public static function isPost(): bool
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
    }
}