<?php

namespace Core\Pages;

use Core\Exceptions\UnauthorizedException;
use Core\Providers\MustacheProvider;
use User;

class AuthenticatedPage extends Page
{
    protected ?User $user = null;

    protected function prepare(): void
    {
        session_start();

        if (!isset($_SESSION['user_id']))
            throw new UnauthorizedException();

        if (!User::exists($_SESSION['user_id']))
            throw new UnauthorizedException();

        $this->user = User::get($_SESSION['user_id']);
    }

    protected function html_header(): string
    {
        $data = [
            'user' => $this->user,
        ];

        return MustacheProvider::get()->render('header', $data);
    }
}