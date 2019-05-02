<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/5
 * Time: 9:51
 */

namespace Simpale\Tool;


use Simpale\File\LogFile;

class Logger
{
    public static function recordingLog(LogFile $logFile, $content)
    {
        $logFile->write($content);
    }
}