<?php

require_once "../bootstrap.php";

use Browse\Pages\Page;
use Browse\Providers\MustacheProvider;

class IndexPage extends Page
{
    protected string $title = "Index";

    protected function html_header(): string
    {
        session_start();

        $data = [
            'user' => (isset($_SESSION['user_id']) && Users::exists($_SESSION['user_id'])) ? Users::get($_SESSION['user_id']) : null,
        ];

        return MustacheProvider::get()->render('header', $data);
    }

    protected function html_head(): string
    {
        return MustacheProvider::get()->render('head', ['title' => $this->title, 'custom_style' => '
        html {
            background-image: url("/public/img/haj.webp");
            background-position: top;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        body {
            backdrop-filter: blur(4px);
            height: 100vh;
            width: 100%;
            margin: 0;
        }']);
    }

    protected function html_main(): string
    {
        return MustacheProvider::get()->render('index');
        //return '<div class="m-2 p-2 glow-text"><h1 class="display-3 my-5">Index</h1></div>';
    }
}

$page = new IndexPage();
$page->render();
