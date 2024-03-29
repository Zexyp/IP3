<?php

namespace Browse\Exceptions;

use Throwable;

class NotFoundException extends BaseException
{
    public function __construct(string $message = "Not Found", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}