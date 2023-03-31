<?php

namespace Browse\Pages;

use Browse\AppConfig;
use Browse\Exceptions\BadRequestException;
use Browse\Exceptions\ForbiddenException;
use Browse\Exceptions\InternalServerErrorException;
use Browse\Exceptions\MethodNotAllowedException;
use Browse\Exceptions\UnauthorizedException;
use Browse\Exceptions\UnprocessableContentException;
use Browse\Providers\MustacheProvider;
use Browse\Exceptions\BaseException;
use Exception;

abstract class Page
{
    protected string $title = '';
    protected ?array $allowed_methods = ['GET'];

    static public function redirect(string $location) : void
    {
        header("Location: $location", true, 302);
    }

    /* used for strictly necessary page specific parameters */
    public static function filter(int $type, string $var_name, int $filter = FILTER_DEFAULT, bool $required = false, array|int $options = 0) {
        $filtered = filter_input($type, $var_name, $filter, $options);

        if ($filtered === null and $required)
            throw new BadRequestException();

        if ($filtered === false)
        {
            if (!$required)
                return null;
            throw new UnprocessableContentException();
        }

        return $filtered;
    }

    protected function authentication() : bool {
        return true;
    }

    protected function prepare() : void {

    }

    protected function http_headers() : void {

    }

    protected function html_head() : string {
        return MustacheProvider::get()->render('head', ['title' => $this->title]);
    }

    protected function html_body() : string {
        $data = [
            'header' => $this->html_header(),
            'main' => $this->html_main(),
            'footer' => $this->html_footer(),
        ];
        return MustacheProvider::get()->render('body', $data);
    }

    protected function html_header() : string {
        return MustacheProvider::get()->render('header', []);
    }

    protected function html_main() : string {
        return '';
    }

    protected function html_footer() : string {
        return MustacheProvider::get()->render('footer', []);
    }

    public function render() : void {
        try {
            if ($this->allowed_methods != null and !in_array($_SERVER['REQUEST_METHOD'], $this->allowed_methods))
                throw new MethodNotAllowedException();

            if (!$this->authentication())
                throw new InternalServerErrorException();

            $this->prepare();

            $this->http_headers();

            $data = [
                'head' => $this->html_head(),
                'body' => $this->html_body(),
            ];

            echo MustacheProvider::get()->render('page', $data);
        }
        catch (BaseException $exception) {
            $page = new ErrorPage($exception);
            $page->render();
            exit;
        }
        catch (Exception $exception) {
            if (AppConfig::get('debug'))
                throw $exception;

            $page = new ErrorPage(new InternalServerErrorException());
            $page->render();
            exit;
        }
    }
}