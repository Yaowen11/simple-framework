<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:14
 */

namespace Simpale\Request;


class RequestFactory
{
    public static function createHttpRequest(): HttpRequest
    {
        return new HttpRequest();
    }
}