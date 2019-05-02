<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2019/3/4
 * Time: 22:21
 */

namespace Simpale\Middleware;


use Simpale\App\Middleware\BeforeMiddleware;
use Simpale\Exception\MiddlewareException;
use Simpale\Tool\GenerateInstanceByReflectionClass;

/**
 * 前置中间件工厂
 * Class BeforeMiddlewareFactory
 * @package Simpale\Middleware
 */
class BeforeMiddlewareFactory
{
    /**
     * @param string $beforeMiddlewareClass
     * @return BeforeMiddleware
     * @throws MiddlewareException
     * @throws \ReflectionException
     */
    public static function createBeforeMiddleware(string $beforeMiddlewareClass): BeforeMiddleware
    {
        $beforeMiddleware = (new GenerateInstanceByReflectionClass($beforeMiddlewareClass))->generateInstance();
        if (!$beforeMiddleware instanceof BeforeMiddleware) {
            throw new MiddlewareException('指定前置中间件未实现指定接口' . $beforeMiddlewareClass);
        }
        return $beforeMiddleware;
    }
}