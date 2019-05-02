<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:09
 */

namespace Simpale\DB;

class MySQL
{
    private static $link;

    private function __construct()
    {
    }

    public static function getSingleMysqliConnection()
    {
        if (self::$link) {
            return self::$link;
        }
        $dbConfig = Config::getConfigOption(FileFactory::createPHPFile(App::configFile()), 'db');
        self::$link = new \mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbName']);
        self::$link->set_charset($dbConfig['charset']);
        return self::$link;
    }

    public static function mysqlFieldTypeHash()
    {
        return [
            1 => 'tinyint',
            2 => 'smallint',
            3 => 'int',
            4 => 'float',
            5 => 'double',
            7 => 'timestamp',
            9 => 'mediumint',
            12 => 'datetime',
            246 => 'decimal',
            252 => 'longtext',
            253 => 'varchar',
            254 => 'char',
        ];
    }
    
}