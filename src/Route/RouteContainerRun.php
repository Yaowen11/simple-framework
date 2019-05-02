<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:35
 */

namespace Simpale\Routing;


use Simpale\Tool\GenerateInstanceByReflectionClass;

trait RouteContainerRun
{
    /**
     * 运行路由方法容器
     * @throws \ReflectionException
     */
    public function run()
    {
        if ($this->isStatic === false && $this->numberOfParameters === 0) {
            $routeAction = (new GenerateInstanceByReflectionClass($this->reflectionMethod->class))->generateInstance();
            call_user_func([$routeAction, $this->reflectionMethod->name]);
        } elseif ($this->isStatic === false && $this->numberOfParameters > 0) {
            $routeAction = (new GenerateInstanceByReflectionClass($this->reflectionMethod->class))->generateInstance();
            call_user_func_array([$routeAction, $this->reflectionMethod->name], $this->prepareMethodParameter());
        } elseif ($this->isStatic && $this->numberOfParameters === 0) {
            $this->reflectionMethod->class::{$this->reflectionMethod->name}();
        } elseif ($this->isStatic && $this->numberOfParameters > 0) {
            call_user_func_array([$this->reflectionMethod->class, $this->reflectionMethod->name], $this->prepareMethodParameter());
        }
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function prepareMethodParameter(): array
    {
        $methodParams = [];
        $reflectionParameters = $this->reflectionMethod->getParameters();
        foreach ($reflectionParameters as $reflectionParameter) {
            if ($reflectionParameter->hasType() && $reflectionParameter->getType() instanceof \ReflectionNamedType) {
                $methodParams[] = $this->getMethodParameterValue($reflectionParameter);
            }  else {
                $methodParams[] = $this->request->getParam($reflectionParameter->getName());
            }
        }
        return $methodParams;
    }

    /**
     * @param \ReflectionParameter $reflectionParameter
     * @return mixed|null
     * @throws \ReflectionException
     */
    private function getMethodParameterValue(\ReflectionParameter $reflectionParameter)
    {
        $parameterType = $reflectionParameter->getType()->getName();
        $parameterName = $reflectionParameter->getName();
        $parameterDefaultValue = $reflectionParameter->isDefaultValueAvailable() ? $reflectionParameter->getDefaultValue() : null;
        $requestParams = $this->request->getParams();
        $parameterValue = null;
        if ($parameterType == 'string') {
            $parameterValue = isset($requestParams[$parameterName]) ? (string) $requestParams[$parameterName] : $parameterDefaultValue;
            $this->request->setParamsKeyValue($parameterName, $parameterValue);
        } elseif ($parameterType == 'float') {
            $parameterValue = isset($requestParams[$parameterName]) ? (float) $requestParams[$parameterName] : $parameterDefaultValue;
            $this->request->setParamsKeyValue($parameterName, $parameterValue);
        } elseif ($parameterType == 'bool') {
            $parameterValue = isset($requestParams[$parameterName]) ? (bool) $requestParams[$parameterName] : $parameterDefaultValue;
            $this->request->setParamsKeyValue($parameterName, $parameterValue);
        } elseif ($parameterType == 'array') {
            $originParamsValue = html_entity_decode($requestParams[$parameterName]);
            if (!empty($originParamsValue)) {
                $parameterValue = json_decode($originParamsValue, true) ?? unserialize($originParamsValue) ?? $parameterDefaultValue;
            }
            $this->request->setParamsKeyValue($parameterName, $parameterValue);
        } elseif ($parameterType == 'int') {
            $parameterValue = isset($requestParams[$parameterName]) ? (int) $requestParams[$parameterName] : $parameterDefaultValue;
            $this->request->setParamsKeyValue($parameterName, $parameterValue);
        } elseif ($parameterType == 'callable') {
            $parameterValue = $parameterDefaultValue;
            $this->request->setParamsKeyValue($parameterName, $parameterValue);
        } elseif ($this->request instanceof $parameterType) {
            $parameterValue = $this->request;
        } elseif (class_exists($parameterType)) {
            $parameterValue = (new GenerateInstanceByReflectionClass($parameterType))->generateInstance();
        }
        return $parameterValue;
    }
}