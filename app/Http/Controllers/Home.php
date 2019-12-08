<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2019/5/7
 * Time: 17:32
 */

namespace App\Http\Controllers;


use Simpale\Response\ResponseFactory;

class Home
{
    public function home()
    {
        ResponseFactory::createJsonResponse('hello world')->response();
    }
    public function test()
    {
        if ($this instanceof Home) {
            return 'he1';
        }
        return 'hello';
    }
}