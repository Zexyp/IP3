<?php

require_once "../bootstrap.php";

use Core\Pages\AuthenticatedPage;
use Core\Providers\MustacheProvider;

class LogoutPage extends AuthenticatedPage
{
    protected function prepare(): void
    {
        session_destroy();
        $this->user = null;
    }

    protected function http_headers(): void
    {
        header('Location: login.php', true, 302);
    }

    protected function html_main(): string
    {
        return MustacheProvider::get()->render('logout');
    }
}

$page = new LogoutPage();
$page->render();
