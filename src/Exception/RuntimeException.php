<?php

namespace Simple\Exception;

use Throwable;

class RuntimeException extends \Exception
{
    use ExceptionToString;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}