<?php

require_once "../bootstrap.php";

use Browse\Pages\AuthenticatedPage;
use Browse\Providers\MustacheProvider;

class LogoutPage extends AuthenticatedPage
{
    protected string $title = "Logout";

    protected function prepare(): void
    {
        parent::prepare();

        session_destroy();
        $this->logged_user = null;
    }

    protected function http_headers(): void
    {
        self::redirect('login.php');
    }

    protected function html_main(): string
    {
        // lol, i know, it will be never seen
        return MustacheProvider::get()->render('authentication/logout');
    }
}

$page = new LogoutPage();
$page->render();
