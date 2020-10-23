<?php


namespace components;


use helpers\Arrays;

class Session
{
    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }
    }

    public function setFlash(string $key, $value)
    {
        $_SESSION['flash'][$key] = $value;
    }

    public function getFlash(string $key)
    {
        $flash = Arrays::getValue($key, $_SESSION['flash'] ?? []);
        if ($flash) {
            unset($_SESSION['flash'][$key]);
        }
        return $flash;
    }

    public function set(string $key, $value)
    {
        $_SESSION['static'][$key] = $value;
    }

    public function get(string $key)
    {
        return Arrays::getValue($key, $_SESSION['static'] ?? []);
    }
}