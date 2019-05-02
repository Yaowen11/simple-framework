<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:29
 */

namespace Simpale\Routing;


use Simpale\Request\HttpRequest;

class HttpRouteContainer implements RouteContainer
{
    private $reflectionMethod;

    private $request;

    private $isStatic;

    private $numberOfParameters;

    use RouteContainerRun;

    public function __construct(\ReflectionMethod $reflectionMethod, HttpRequest $request)
    {
        $this->reflectionMethod = $reflectionMethod;
        $this->request = $request;
        $this->isStatic = $reflectionMethod->isStatic();
        $this->numberOfParameters = $reflectionMethod->getNumberOfParameters();
    }


}