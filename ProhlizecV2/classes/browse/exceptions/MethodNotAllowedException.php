<?php

namespace Browse\Exceptions;

class MethodNotAllowedException extends BaseException
{
    public function __construct(string $message = "Method Not Allowed", int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}