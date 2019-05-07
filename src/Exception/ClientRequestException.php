<?php

namespace Simple\Exception;

use Throwable;

/**
 * 请求异常
 * Class ClientRequestException
 * @package Simple\Exception
 */
class ClientRequestException extends \Exception
{
    use ExceptionToString;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}