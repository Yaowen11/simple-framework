<?php

namespace Simple\Exception;

use Throwable;

class SecurityException extends \Exception
{
    use ExceptionToString;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}