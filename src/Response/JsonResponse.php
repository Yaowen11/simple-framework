<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:38
 */

namespace Simpale\Response;


class JsonResponse implements Response
{
    private $httpCode;

    private $httpEntry;

    public function __construct($httpEntry, $httpCode = 200)
    {
        $this->httpCode = $httpCode;
        $this->httpEntry = $this->checkHttpEntry($httpEntry) ? json_encode($httpEntry, JSON_UNESCAPED_UNICODE) : json_encode(new \stdClass());
    }

    private function checkHttpEntry($entry) : bool
    {
        if (is_object($entry) || is_array($entry)) {
            return true;
        } else {
            return false;
        }
    }

    public function response()
    {
        header(Response::HTTP_PROTOCOL_VERSION . ' ' . $this->httpCode);
        header(Response::CONTENT_TYPE_JSON);
        echo $this->httpEntry;
        fastcgi_finish_request();
    }

}