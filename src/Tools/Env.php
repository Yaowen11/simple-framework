<?php

namespace Simple\Tools;

class Env
{
    private static $defaultEnvFile = '.env';

    private static function getEnvFile(): string
    {
        return Path::rootPath() . self::$defaultEnvFile;
    }

    private static function env(): array
    {
        return parse_ini_file(self::getEnvFile(), true);
    }

    public static function get(string $key): ?string
    {
        if (strpos($key, '.')) {
            $keys = explode('.', $key);
            return self::env()[$keys[0]][$keys[1]];
        }
        return self::env()[$key];
    }
}