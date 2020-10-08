<?php


namespace helpers;


class Dir
{
    public static function scan($dir, $files_only = true)
    {
        $files = [];
        foreach (scandir($dir) as $file) {
            if (in_array($file, ['.', '..'])) continue;
            if ($files_only) {
                if (is_dir($dir . $file)) continue;
            }

            $files[] = $file;
        }
        return $files;
    }
}