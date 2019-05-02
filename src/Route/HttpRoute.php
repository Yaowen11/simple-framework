<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 17:20
 */

namespace Simpale\Route;

use Simpale\exception\MiddlewareException;

class HttpRoute
{
    private $routes = [];

    private $currentMethod = '';

    private $currentUrl = '';

    const MIDDLEWARE_PREFIX = 'Simpale\App\Middleware\\';

    const ROUTES_URL_ACTION_PREFIX = 'action';

    const ROUTES_URL_BEFORE_MIDDLEWARE_PREFIX = 'before';

    const ROUTES_URL_AFTER_MIDDLEWARE_PREFIX = 'after';

    public function __construct()
    {
        if ($this->routes !== []) {
            $this->routes = [];
        }
    }

    /**
     * 注册请求url到路由数组中
     * @param string $method
     * @param string $url
     * @param string $action
     * @return $this
     */
    public function action(string $method, string $url, string $action)
    {
        $this->currentMethod = $method;
        $this->currentUrl = $url;
        $this->routes[$this->currentMethod][$this->currentUrl][static::ROUTES_URL_ACTION_PREFIX] = $action;
        return $this;
    }

    /**
     * 为url注册前置中间件,运行时生成中间件实例
     * @param $beforeMiddleware
     * @return $this
     * @throws MiddlewareException
     */
    public function beforeMiddleware($beforeMiddleware)
    {
        if (is_array($beforeMiddleware) && !empty($beforeMiddleware)) {
            foreach ($beforeMiddleware as $middleware) {
                $middlewareClass = static::MIDDLEWARE_PREFIX . $middleware;
                if (class_exists($middlewareClass)) {
                    $this->routes[$this->currentMethod][$this->currentUrl][static::ROUTES_URL_BEFORE_MIDDLEWARE_PREFIX][] = $middlewareClass;
                } else {
                    throw new MiddlewareException('未找到指定中间件或中间件未实现指定接口' . $middlewareClass);
                }
            }
        }
        $middlewareClass = static::MIDDLEWARE_PREFIX . $beforeMiddleware;
        if (class_exists($middlewareClass)) {
            $this->routes[$this->currentMethod][$this->currentUrl][static::ROUTES_URL_BEFORE_MIDDLEWARE_PREFIX][] = $middlewareClass;
        } else {
            throw new MiddlewareException('未找到指定中间件或中间件未实现指定接口' . $middlewareClass);
        }
        return $this;
    }

    /**
     * 为url注册后置路由，运行时生成中间件实例
     * @param $afterMiddleware
     * @return $this
     * @throws MiddlewareException
     */
    public function afterMiddleware($afterMiddleware)
    {
        if (is_array($afterMiddleware) && !empty($afterMiddleware)) {
            foreach ($afterMiddleware as $middleware) {
                $middlewareClass = static::MIDDLEWARE_PREFIX . $middleware;
                if (class_exists($middlewareClass)) {
                    $this->routes[$this->currentMethod][$this->currentUrl][static::ROUTES_URL_AFTER_MIDDLEWARE_PREFIX][] = $middlewareClass;
                } else {
                    throw new MiddlewareException('未找到指定中间件或中间件未实现指定接口' . $middlewareClass);
                }
            }
        }
        $middlewareClass = static::MIDDLEWARE_PREFIX . $afterMiddleware;
        if (class_exists($middlewareClass)) {
            $this->routes[$this->currentMethod][$this->currentUrl][static::ROUTES_URL_AFTER_MIDDLEWARE_PREFIX][] = $middlewareClass;
        } else {
            throw new MiddlewareException('未找到指定中间件或中间件未实现指定接口' . $middlewareClass);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}