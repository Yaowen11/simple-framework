<?php

namespace Simple\Bootstrap;

use App\Console\Command;
use Simple\Helper\App;
use Simple\Error\Error;

class Main
{
    private static function initialize(): void
    {
        $timezone = App::config('timezone');
        if (date_default_timezone_get() !== $timezone) {
            date_default_timezone_set($timezone);
        }
        $env = App::config('env');
        if ($env !== 'product') {
            Error::register();
        }
    }

    private static function prepare(): \SplQueue
    {
        return (new HttpPrepare($_SERVER['REQUEST_METHOD'], substr($_SERVER['REQUEST_URI'], 1)))->prepare();
    }

    public static function run(): void
    {
        self::initialize();
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $httpQueue = self::prepare();
            while (!$httpQueue->isEmpty()) {
                $httpQueue->dequeue()->run();
            }
            exit;
        } else {
            Command::run();
        }
    }
}