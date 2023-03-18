<?php

require_once "../bootstrap.php";

use Core\Exceptions\BadRequestException;
use Core\Pages\Page;
use Core\Providers\MustacheProvider;

class LoginPage extends Page
{
    protected string $title = 'Login';
    protected ?array $allowed_methods = ['GET', 'POST'];

    protected bool $error = false;
    protected string $username = '';
    protected bool $success = false;

    protected function prepare(): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
            return;

        if (!isset($_POST['username']) or
            !isset($_POST['password']))
            throw new BadRequestException();

        $this->username = $_POST['username'];
        $user = User::get_login($_POST['username'], hash('sha256', ($_POST['password'])));

        if ($user === null) {
            $this->error = true;
            return;
        }

        session_start();

        $_SESSION['user_id'] = $user->user_id;

        $this->success = true;
    }

    protected function http_headers(): void
    {
        if ($this->success)
            self::redirect('/');
    }

    protected function html_head(): string
    {
        return MustacheProvider::get()->render('head', ['title' => $this->title, 'custom_style' => '
        body {
            background-image: url("/public/img/login.png");
            background-size: cover;
        }']);
    }

    protected function html_main(): string
    {
        $data = [
            'alert' => !$this->error ? '' : MustacheProvider::get()->render('alert', [
                'message' => 'Invalid Username or Password',
                'alert_type' => 'alert-danger']),
            'username' => $this->username,
        ];
        return MustacheProvider::get()->render('login', $data);
    }

    protected function html_header(): string
    {
        return MustacheProvider::get()->render('header', ['fix_login' => true]);
    }
}

$page = new LoginPage();
$page->render();
