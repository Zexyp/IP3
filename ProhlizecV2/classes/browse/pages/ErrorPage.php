<?php

namespace Browse\Pages;

use Browse\AppConfig;
use Browse\Exceptions\BaseException;
use Browse\Providers\MustacheProvider;

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

        $this->title = "{$this->exception->getMessage()} {$this->exception->getCode()}";
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

        if (AppConfig::get('debug')) {
            $data['debug'] = true;
            $data['trace'] = $this->exception->getTrace();
        }

        return MustacheProvider::get()->render('error', $data);
    }
}