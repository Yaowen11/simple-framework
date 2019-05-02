<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2019/3/4
 * Time: 22:22
 */

namespace Simpale\Middleware;

use Simpale\Exception\MiddlewareException;
use Simpale\Tool\GenerateInstanceByReflectionClass;
use Simpale\App\Middleware\AfterMiddleware;

class AfterMiddlewareFactory
{
    /**
     * 后置中间件工厂
     * @param string $afterMiddlewareClass
     * @return AfterMiddleware
     * @throws MiddlewareException
     * @throws \ReflectionException
     */
    public static function createAfterMiddleware(string $afterMiddlewareClass) : AfterMiddleware
    {
        $afterMiddleware = (new GenerateInstanceByReflectionClass($afterMiddlewareClass))->generateInstance();
        if (!$afterMiddleware instanceof AfterMiddleware) {
            throw new MiddlewareException('指定后置中间件未实现指定接口' . $afterMiddlewareClass);
        }
        return $afterMiddleware;
    }
}