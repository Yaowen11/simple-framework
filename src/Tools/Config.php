<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:25
 */

namespace Simpale\Tool;

use Simple\File\FileFactory;

class Config
{
    public static function getConfig(string $config)
    {
        if (!strpos($config, '.')) {
            return FileFactory::createPHPFile($config)->read();
        }
        $configKeys = explode('.', $config);
        return FileFactory::createPHPFile($configKeys[0])->read()[1];

    }

}