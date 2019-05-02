<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 15:05
 */

namespace Simpale\App\Middleware;


use Simpale\Bootstrap\Main;
use Simpale\Exception\SecurityException;
use Simpale\File\FileFactory;
use Simpale\Helper\App;
use Simpale\Helper\Helper;
use Simpale\Request\Request;
use Simpale\Tool\Config;

class HttpSecurity implements BeforeMiddleware
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function run()
    {
        if ($this->request->hasHeader('security')) {
            $security = $this->request->getHeader('security');
            if ($security !== App::config('client_security')) {
                throw new SecurityException('请求主机安全验证出错');
            }
        } else {
            throw new SecurityException('该请求主机不安全，请先注册');
        }
    }
}