<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:37
 */

namespace Simpale\Response;


interface Response
{
    const HTTP_PROTOCOL_VERSION = 'HTTP/1.1';

    const CONTENT_TYPE_JSON = 'Content-Type: application/json; charset=utf-8';

    public function response();
}