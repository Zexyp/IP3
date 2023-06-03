<?php

namespace Browse\Exceptions;

use Throwable;

class NotImplementedException extends BaseException
{
    public function __construct(string $message = "Not Implemented", int $code = 501, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}