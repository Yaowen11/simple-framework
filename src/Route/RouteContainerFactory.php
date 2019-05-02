<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:31
 */

namespace Simpale\Routing;


use Simpale\Request\RequestFactory;

class RouteContainerFactory
{
    /**
     * 路由动作容器工厂
     * @param $httpAction
     * @return HttpRouteContainer
     * @throws \ReflectionException
     */
    public static function createHttpRouteContainer($httpAction): HttpRouteContainer
    {
        $classAndAction = unserialize($httpAction);
        return new HttpRouteContainer(new \ReflectionMethod($classAndAction['class'], $classAndAction['method']), RequestFactory::createHttpRequest());
    }
}