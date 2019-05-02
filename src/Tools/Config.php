<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:25
 */

namespace Simpale\Tool;

use Simple\Tools\Path;

class Config
{
    const AppConfig = 'app.php';

    const DatabaseConfig = 'database.php';

    public static function getAppConfig(string $key): ?string
    {
        return self::getConfig(self::AppConfig, $key);
    }

    private static function getConfig(string $config): array
    {
        if (file_exists(Path::configPath() . $config)) {
            return include Path::configPath() . $config;
        }
        return [];
    }

    private static function getArrayKeys(array $config, string $key)
    {
        
    }
}