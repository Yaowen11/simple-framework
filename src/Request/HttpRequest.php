<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:14
 */

namespace Simpale\Request;

use Simpale\Tool\Config;
use Simpale\File\FileFactory;
use Simpale\Helper\App;

class HttpRequest implements Request
{
    private $requestParams = [];

    private $requestHeader = [];

    private $requestUrl;

    private $requestAddr;

    private $requestMethod;

    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->setRequestHeader();
        $this->requestUrl = $_SERVER['REQUEST_URI'];
        $this->requestAddr = $_SERVER['REMOTE_ADDR'];
        if ($this->requestMethod == 'GET') {
            $this->requestParams = $_GET;
        } elseif ($this->requestMethod == 'POST') {
            $this->requestParams = $_REQUEST;
        } else {
            $this->requestParams = static::restFullParams();
        }
    }

    public function getHeader(string $key)
    {
        return $this->requestHeader[$key];
    }

    public function getHeaders(): array
    {
        return $this->requestHeader;
    }

    public function hasHeader(string $key): bool
    {
        return isset($this->requestHeader[$key]);
    }

    public function has(string $key): bool
    {
        return isset($this->requestParams[$key]);
    }

    public function getParams(): array
    {
        return $this->requestParams;
    }

    public function getParam(string $key)
    {
        return $this->requestParams[$key];
    }

    public function setParamsKeyValue(string $key, $value)
    {
        $this->requestParams[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * @return mixed
     */
    public function getRequestAddr()
    {
        return $this->requestAddr;
    }

    /**
     * @return array
     */
    public static function restFullParams(): array
    {
        $input = (file_get_contents('php://input'));
        if (empty($input)) {
            return [];
        }
        if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/x-www-form-urlencoded') {
            $inputParamsArray = explode('&', urldecode($input));
            $requestParams = [];
            foreach ($inputParamsArray as $inputParam) {
                $tmpInputKeyAndValue = explode('=', $inputParam);
                $requestParams[$tmpInputKeyAndValue[0]] = $tmpInputKeyAndValue[1];
            }
            return $requestParams;
        }
        $keyParams = explode(' ', $input);
        $requestParams = [];
        foreach ($keyParams as $keyParam) {
            if (preg_match('/^name/', $keyParam)) {
                $key = '';
                $keyParamArray = array_filter(explode('?', preg_replace('/[\f\n\r\t\v ]/', '?', $keyParam)));
                foreach ($keyParamArray as $item) {
                    if (preg_match('/^\-+/', $item) || $item === 'Content-Disposition:') {
                        continue;
                    }
                    if (preg_match('/^name=/', $item)) {
                        $key = trim(explode('=', $item)[1], '"');
                    }
                    $requestParams[$key] = $item;
                }
            }
        }
        return $requestParams;
    }

    /**
     *
     */
    private function setRequestHeader()
    {
        $allowedHeaders = Config::getConfigOption(FileFactory::createPHPFile(App::configFile()), 'allowed_headers');
        if (empty($allowedHeaders)) {
            $this->requestHeader = [];
        } else {
            if (function_exists('getallheaders')) {
                $requestHeader = getallheaders();
                foreach ($allowedHeaders as $header) {
                    if (isset($requestHeader[ucfirst($header)])) {
                        $this->requestHeader[$header] = $requestHeader[ucfirst($header)];
                    }
                }
            } else {
                foreach ($allowedHeaders as $header) {
                    if (isset($_SERVER['HTTP_' . strtoupper($header)])) {
                        $this->requestHeader[$header] = $_SERVER['HTTP_' . strtoupper($header)];
                    }
                }
            }
        }
    }

    private function htmlFilter($array)
    {
        return array_map(function ($value) {
            return htmlspecialchars($value);
        }, $array);
    }



}