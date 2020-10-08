<?php


namespace helpers;


class Dir
{
    public static function scan($dir)
    {
        $files = [];
        foreach (scandir($dir) as $file) {
            if (in_array($file, ['.', '..']) || is_dir($dir . $file)) {
                continue;
            }
            $files[] = $file;
        }
        return $files;
    }
}