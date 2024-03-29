<?php

// TODO: fix state when logged in

require_once "../bootstrap.php";

use Browse\Exceptions\BadRequestException;
use Browse\Pages\Page;
use Browse\Providers\MustacheProvider;

class LoginPage extends Page
{
    protected string $title = 'Login';
    protected ?array $allowed_methods = ['GET', 'POST'];

    protected ?string $username = '';
    protected bool $error = false;
    protected bool $success = false;
    protected bool $already = false;
    protected ?Users $user = null;

    protected function prepare(): void
    {
        session_start();

        if (isset($_SESSION['user_id']))
        {
            if (Users::exists($_SESSION['user_id']))
            {
                $this->user = Users::get($_SESSION['user_id']);
                $this->already = true;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['username']) or
                !isset($_POST['password']))
                throw new BadRequestException();

            $this->username = $_POST['username'];
            $user = Users::get_login($_POST['username'], hash('sha256', $_POST['password']));

            if ($user === null) {
                $this->error = true;
                return;
            }

            $_SESSION['user_id'] = $user->user_id;

            $this->success = true;
        }
    }

    protected function http_headers(): void
    {
        if ($this->success)
            self::redirect('/');
    }

    protected function html_head(): string
    {
        return MustacheProvider::get()->render('head', ['title' => $this->title, 'custom_style' => '
        html {
            background-image: url("/public/img/login.png");
            background-position: bottom;
            background-repeat: no-repeat;
            background-size: cover;
        }']);
    }

    protected function html_main(): string
    {
        $alert = '';

        if ($this->error)
            $alert .= MustacheProvider::get()->render('alert', [
                'message' => 'Invalid Username or Password',
                'alert_type' => 'alert-danger']);
        if ($this->already)
            $alert .= MustacheProvider::get()->render('alert', [
                'message' => "You are already logged in as '{$this->user->username}'",
                'alert_type' => 'alert-warning']);

        $data = [
            'alert' => $alert,
            'username' => $this->username,
        ];
        return MustacheProvider::get()->render('authentication/login', $data);
    }

    protected function html_header(): string
    {
        return MustacheProvider::get()->render('header', ['fix_login' => true, 'user' => $this->user]);
    }
}

$page = new LoginPage();
$page->render();
