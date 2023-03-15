<?php

namespace Core\Pages;

use Core\Providers\MustacheProvider;
use User;

class AuthenticatedPage extends Page
{
    protected ?User $user = null;

    protected function authentication(): bool
    {
        session_start();

        if (!isset($_SESSION['user_id']))
            return false;

        if (User::exists($_SESSION['user_id'])) {
            $this->user = User::get($_SESSION['user_id']);
            return true;
        }

        return false;
    }

    protected function html_header(): string
    {
        $data = [
            'user' => $this->user,
        ];

        var_dump($data);

        return MustacheProvider::get()->render('header', $data);
    }
}