<?php

namespace Simple\File;

class FileFactory
{
    public static function createJsonFile(string $file)
    {
        return new JsonFile($file);
    }

    public static function createPHPFile(string $file)
    {
        return new PHPFile($file);
    }

    public static function createLogFile(string $file)
    {
        return new LogFile($file);
    }
}