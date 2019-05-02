<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 17:19
 */

namespace Simpale\Route;

use Simpale\Exception\ClassNotFoundException;
use Simpale\Exception\RouteException;
use Simpale\Helper\App;

/**
 * httpRoute工厂，加载所有路由文件，注册routes
 * Class HttpRouteFactory
 * @package Simpale\Route
 */
class HttpRouteFactory
{
    const APP_NAMESPACE = 'Simpale\App\Controllers\\';

    private static $route = null;
    /**
     * 注册get请求
     * @param string $url
     * @param string $action
     * @return HttpRoute
     * @throws ClassNotFoundException
     * @throws RouteException
     */
    public static function get(string $url, string $action)
    {
        return static::createRoute()->action('GET', $url, static::verifyRoute($action));
    }

    /**
     * 注册post请求
     * @param string $url
     * @param string $action
     * @return HttpRoute
     * @throws ClassNotFoundException
     * @throws RouteException
     */
    public static function post(string $url, string $action)
    {
        return static::createRoute()->action('POST', $url, static::verifyRoute($action));
    }

    /**
     * 注册put请求
     * @param string $url
     * @param string $action
     * @return HttpRoute
     * @throws ClassNotFoundException
     * @throws RouteException
     */
    public static function put(string $url, string $action)
    {
        static::verifyRoute($action);
        return static::createRoute()->action('PUT', $url, static::verifyRoute($action));
    }

    /**
     * 注册patch请求
     * @param string $url
     * @param string $action
     * @return HttpRoute
     * @throws ClassNotFoundException
     * @throws RouteException
     */
    public static function patch(string $url, string $action)
    {
        return static::createRoute()->action('PATCH', $url, static::verifyRoute($action));
    }

    /**
     * 注册delete请求
     * @param string $url
     * @param string $action
     * @return HttpRoute
     * @throws ClassNotFoundException
     * @throws RouteException
     */
    public static function delete(string $url, string $action)
    {
        return static::createRoute()->action('DELETE', $url, static::verifyRoute($action));
    }

    /**
     * 获取路由数组
     * @return mixed
     */
    public static function getRoutes()
    {
        return self::createRoute()->getRoutes();
    }

    /**
     * 加载路由文件
     * @param $file
     * @throws RouteException
     */
    public static function load($file)
    {
        static::createRoute();
        if (is_array($file) && !empty($file)) {
            foreach ($file as $routeFile) {
                $routeFilePath = App::rootPath() . $routeFile;
                if (file_exists($routeFilePath)) {
                    require $routeFilePath;
                } else {
                    throw new RouteException('未找到对于路由文件' . $routeFilePath);
                }
            }
        } else {
            $routeFilePath = App::rootPath() . $file;
            if (file_exists($routeFilePath)) {
                require $routeFilePath;
            } else {
                throw new RouteException('未找到对于路由文件' . $routeFilePath);
            }
        }
    }

    /**
     * 验证请求路由
     * @param string $action
     * @return string
     * @throws ClassNotFoundException
     * @throws RouteException
     */
    private static function verifyRoute(string $action)
    {
        $classAndAction = explode('@', $action);
        if (empty($classAndAction) || count($classAndAction) !== 2) {
            throw new RouteException('路由定义错误' . $action);
        }
        $class = static::APP_NAMESPACE .$classAndAction[0];
        if (!class_exists($class)) {
            throw new ClassNotFoundException($class[0]);
        }
        $classMethods = get_class_methods($class);
        if (array_search($classAndAction[1], $classMethods) === false) {
            throw new RouteException('指定方法不可调用' . $classAndAction[1]);
        }
        return serialize(['class' => $class, 'method' => $classAndAction[1]]);
    }

    /**
     * 生成httpRoute单例
     * @return HttpRoute
     */
    private static function createRoute(): HttpRoute
    {
        if (is_null(static::$route)) {
            static::$route = new HttpRoute;
        }
        return static::$route;
    }
}