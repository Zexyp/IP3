<?php

namespace Browse\Exceptions;

use Throwable;

class InternalServerErrorException extends BaseException
{
    public function __construct(string $message = "Internal Server Error", int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}