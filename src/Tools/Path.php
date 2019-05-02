<?php

namespace Simple\Tools;

class Path
{
    const ConfigFolder = 'config';

    const AppConfigFile = 'app.php';

    const LogFolder = 'log';

    const RouteFolder = 'routes';

    public static function rootPath()
    {
        return substr($_SERVER['DOCUMENT_ROOT'], 0, -6);
    }

    public static function configFile()
    {
        return self::rootPath() . self::ConfigFolder . self::AppConfigFile;
    }

    public static function logPath()
    {
        return self::rootPath() . self::LogFolder;
    }

    public static function configPath()
    {
        return self::rootPath() . self::ConfigFolder;
    }

    public static function routePath()
    {
        return self::rootPath() . self::RouteFolder;
    }
}