<?php

namespace Core\Pages;

use Core\AppConfig;
use Core\Exceptions\ForbiddenException;
use Core\Exceptions\InternalServerErrorException;
use Core\Exceptions\MethodNotAllowedException;
use Core\Exceptions\UnauthorizedException;
use Core\Providers\MustacheProvider;
use Core\Exceptions\BaseException;
use Exception;

class Page
{
    protected string $title = '';
    protected ?array $allowed_methods = ['GET'];

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
                throw new UnauthorizedException();

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