<?php

namespace Sven\ForgeCLI;

class Util
{
    public static function getConfigFilePath(): string
    {
        $visible = self::getHomeDirectory().DIRECTORY_SEPARATOR.'forge.json';

        // If a file named "forge.json" already exists in the user's home
        // folder, we will use that one. If not, we will fall back to
        // a hidden file named ".forge.json" instead and use that.
        if (file_exists($visible)) {
            return $visible;
        }

        return self::getHomeDirectory().DIRECTORY_SEPARATOR.'.forge.json';
    }

    public static function getHomeDirectory(): string
    {
        if (self::isWindows()) {
            return $_SERVER['USERPROFILE'];
        }

        return $_SERVER['HOME'];
    }

    /**
     * @return bool
     */
    public static function isWindows(): bool
    {
        return strncasecmp(PHP_OS_FAMILY, 'WIN', 3) === 0;
    }
}
