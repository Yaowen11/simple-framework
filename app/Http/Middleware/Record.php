<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 15:06
 */

namespace Simpale\App\Middleware;


use Simpale\File\FileFactory;
use Simpale\Helper\App;
use Simpale\Tool\Config;
use Simpale\Tool\Logger;

class Record implements AfterMiddleware
{
    public function run()
    {
        $logConf = Config::getConfigOption(FileFactory::createPHPFile(App::configFile()), 'log');
        $runLog = App::logPath() . $logConf['run'];
        $content = [
            'start' => $_SERVER['REQUEST_TIME_FLOAT'],
            'end' => microtime(true),
            'date' => date('Y-m-d H:i:s', time()),
            'url' => $_SERVER['REQUEST_URI'],
            'method' => $_SERVER['REQUEST_METHOD'],
            'addr' => $_SERVER['REMOTE_ADDR'],
        ];
        Logger::recordingLog(FileFactory::createLogFile($runLog), $content);
    }
}