<?php

namespace Browse\Exceptions;

use Throwable;

class ForbiddenException extends BaseException
{
    public function __construct(string $message = "Forbidden", int $code = 403, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}