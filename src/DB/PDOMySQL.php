<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/13
 * Time: 10:25
 */

namespace Simpale\DB;


use Simpale\Helper\App;

class PDOMySQL
{
    private static $link;

    private function __construct()
    {
    }

    public static function getLink()
    {
        if (self::$link) {
            return self::$link;
        }
        $dbConfig = App::config('db');
        $dsn = 'mysql:dbname=' . $dbConfig['dbName'] . ';host=' . $dbConfig['host'] . ';port=' . $dbConfig['port']  . ';charset=' . $dbConfig['charset'];
        self::$link = new \PDO($dsn, $dbConfig['username'], $dbConfig['password']);
        return self::$link;
    }

}