<?php


namespace Simple\Error;


class Error
{
    public static function register()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        ini_set('error_log', '');
    }
}