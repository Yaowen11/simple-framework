<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/5
 * Time: 11:05
 */

namespace Simpale\Tool;

/**
 * 根据反射类生成实例
 * Class GenerateInstanceByReflectionMethod
 * @package Simpale\Tool
 */
class GenerateInstanceByReflectionClass
{
    private $reflectionClass;

    private $reflectionConstruct = null;

    private $class;

    /**
     * GenerateInstanceByReflectionClass constructor.
     * @param $class
     * @throws \ReflectionException
     */
    public function __construct($class)
    {
        $this->class = $class;
        $this->reflectionClass = new \ReflectionClass($class);
        $this->reflectionConstruct = $this->reflectionClass->getConstructor();
    }

    /**
     * @return object
     * @throws \ReflectionException
     */
    public function generateInstance()
    {
        if (is_null($this->reflectionConstruct)) {
            return $this->reflectionClass->newInstance();
        }
        if ($this->reflectionConstruct->getNumberOfParameters() === 0) {
            return $this->reflectionClass->newInstance();
        } else {
            return $this->reflectionClass->newInstanceArgs(GenerateMethodParamsByReflectionMethod::getReflectionMethodParamsValue($this->reflectionConstruct));
        }
    }
}