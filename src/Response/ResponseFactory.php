<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:39
 */

namespace Simpale\Response;


class ResponseFactory
{
    public static function createJsonResponse($entry, int $code = 200)
    {
        return new JsonResponse($entry, $code);
    }

    public static function createClientErrorResponse($errorMsg, $code = 400)
    {
        return new ClientErrorResponse($errorMsg, $code);
    }

    public static function createServerErrorResponse($errorMsg, $code = 500)
    {
        return new ServerErrorResponse($errorMsg, $code);
    }
}