<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/5
 * Time: 11:12
 */

namespace Simpale\Tool;


use Simpale\Helper\Helper;
use Simpale\Request\RequestFactory;

class GenerateMethodParamsByReflectionMethod
{
    /**
     * @param \ReflectionMethod $reflectionMethod
     * @return array
     * @throws \ReflectionException
     */
    public static function getReflectionMethodParamsValue(\ReflectionMethod $reflectionMethod): array
    {
        $methodParams = [];
        $reflectionMethodParameters = $reflectionMethod->getParameters();
        foreach ($reflectionMethodParameters as $reflectionParameter) {
            if ($reflectionParameter->hasType() && $reflectionParameter->getType() instanceof \ReflectionNamedType) {
                $methodParams[] = static::getReflectionParameterValue($reflectionParameter);
            }
        }
        return $methodParams;
    }

    /**
     * @param \ReflectionParameter $reflectionParameter
     * @return \Simpale\Request\HttpRequest|mixed|null
     * @throws \ReflectionException
     */
    private static function getReflectionParameterValue(\ReflectionParameter $reflectionParameter) {
        $parameterType = $reflectionParameter->getType()->getName();
        $parameterDefaultValue = $reflectionParameter->isDefaultValueAvailable() ? $reflectionParameter->getDefaultValue() : null;
        if ($parameterType == 'string' || $parameterType == 'bool' || $parameterType == 'array' || $parameterType == 'int' || $parameterType == 'float' || $parameterType == 'callable') {
            return $parameterDefaultValue;
        }
        if (class_exists($parameterType)) {
            return (new GenerateInstanceByReflectionClass($parameterType))->generateInstance();
        }
        if (interface_exists($parameterType) && $parameterType == 'Simpale\Request\Request') {
            return RequestFactory::createHttpRequest();
        }
        return null;
    }
}