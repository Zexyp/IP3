<?php

namespace Browse\Exceptions;

class UnprocessableContentException extends BaseException
{
    public function __construct(string $message = "Unprocessable Content", int $code = 422, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}