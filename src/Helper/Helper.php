<?php

namespace Simple\Helper;

class Helper
{
    /**
     * 输出 json
     * @param mixed ...$print
     */
    public static function dump($print, $isExit = false)
    {
        if (is_array($print) || is_object($print)) {
            echo json_encode($print, 256);
        } else {
            echo json_encode(['var' => $print], 256);
        }
        if ($isExit) {
            exit;
        }
    }

    /**
     * 获取当前环境信息
     */
    public static function env()
    {
        echo json_encode(['env' => getenv(), 'server' => $_SERVER], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    public static function dd($var, $isExit = true)
    {
        var_dump($var);
        if ($isExit) {
            exit;
        }
    }

    public static function fileDebug($dumpVar, $isExit = false)
    {
        file_put_contents('test', json_encode([
            'var' => $dumpVar,
            'time' => date('Y-m-d H:i:s')
        ], 256) . PHP_EOL, FILE_APPEND);
        if ($isExit) {
            exit;
        }
    }
}