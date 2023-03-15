<?php

namespace Core\Pages;

use Core\Exceptions\BaseException;
use Core\Providers\MustacheProvider;

class ErrorPage extends Page
{
    protected ?array $allowed_methods = null;

    protected BaseException $exception;

    public function __construct(BaseException $exception)
    {
        $this->exception = $exception;
    }

    protected function prepare(): void
    {
        parent::prepare();

        $this->title = "Error {$this->exception->getCode()}";
    }

    protected function http_headers(): void
    {
        parent::http_headers();

        http_response_code($this->exception->getCode());
    }

    protected function html_main(): string
    {
        $data = [
            'code' => $this->exception->getCode(),
            'message' => $this->exception->getMessage(),
        ];

        return MustacheProvider::get()->render('error', $data);
    }
}