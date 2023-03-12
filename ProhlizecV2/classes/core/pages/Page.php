<?php

namespace Core\Pages;

use Core\AppConfig;
use Core\Providers\MustacheProvider;
use Core\Exceptions\BaseException;
use Exception;

class Page
{
    public string $title = "";

    protected function prepare() : void {

    }

    protected function http_headers() : void {

    }

    protected function html_head() : string {
        return MustacheProvider::get()->render("head", ["title" => $this->title]);
    }

    protected function html_body() : string {
        return MustacheProvider::get()->render("header", []);
    }

    public function render() : void {
        try {
            $this->prepare();

            $this->http_headers();

            $data = [
                "head" => $this->html_head(),
                "body" => $this->html_body(),
            ];

            echo MustacheProvider::get()->render("page", $data);
        }
        catch (BaseException $exception) {
            die("rip");
        }
        catch (Exception $exception) {
            if (AppConfig::get("debug")) {
                throw $exception;
            }
            die("lmao");
        }
    }
}