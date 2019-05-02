<?php

use Simple\Tools\Env;
use Simple\Tools\Path;

return [
    'env' => Env::get('ENV') ?? 'local',
    'timezone' => 'Asia/Shanghai',
    'error_log' => 'daily',
    'http_route_file' => [
        Path::rootPath() . 'api.php'
    ]
];