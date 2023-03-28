<?php

namespace Browse\Pages;

use Browse\Exceptions\UnauthorizedException;
use Browse\Providers\MustacheProvider;
use Users;

abstract class AuthenticatedPage extends Page
{
    protected ?Users $logged_user = null;

    protected function prepare(): void
    {
        session_start();

        if (!isset($_SESSION['user_id']))
            throw new UnauthorizedException();

        if (!Users::exists($_SESSION['user_id']))
        {
            session_destroy();
            throw new UnauthorizedException();
        }

        $this->logged_user = Users::get($_SESSION['user_id']);
    }

    protected function html_header(): string
    {
        $data = [
            'user' => $this->logged_user,
        ];

        return MustacheProvider::get()->render('header', $data);
    }
}