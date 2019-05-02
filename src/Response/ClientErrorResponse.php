<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/7
 * Time: 9:55
 */

namespace Simpale\Response;


use Simpale\File\FileFactory;
use Simpale\Helper\App;
use Simpale\Request\RequestFactory;
use Simpale\Tool\Logger;

class ClientErrorResponse implements Response
{
    private $errorMsg;

    private $code;

    public function __construct($errorMsg, $code)
    {
        $this->errorMsg = $errorMsg;
        $this->code = $code;
    }

    public function response()
    {
        $responseMsg = '';
        if (is_string($this->errorMsg)) {
            $responseMsg = $this->errorMsg;
        }
        if (is_object($this->errorMsg) || is_array($this->errorMsg)) {
            $responseMsg = json_encode($this->errorMsg, JSON_UNESCAPED_UNICODE);
        }
        header(Response::HTTP_PROTOCOL_VERSION . ' ' . $this->code);
        header(Response::CONTENT_TYPE_JSON);
        echo $responseMsg;
        fastcgi_finish_request();
        $this->recordClientError();
    }

    /**
     * 将请求错误写入客户端错误日志
     */
    private function recordClientError()
    {
        $logFile = FileFactory::createLogFile(App::logPath() . App::config('log')['client_error']);
        $request = RequestFactory::createHttpRequest();
        Logger::recordingLog($logFile, [
            'response_msg' => $this->errorMsg,
            'request_param' => $request->getParams(),
            'request_header' => $request->getHeaders(),
            'request_url' => $request->getRequestUrl(),
            'request_method' => $_SERVER['REQUEST_METHOD'],
            'date' => date('Y-m-d H:i:s'),
        ]);
    }
}