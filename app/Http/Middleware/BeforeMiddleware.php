<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:07
 */

namespace Simpale\App\Middleware;


interface BeforeMiddleware
{
    public function run();
}