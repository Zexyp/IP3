<?php

require_once "../bootstrap.php";

use Browse\Exceptions\NotFoundException;
use Browse\Exceptions\UnprocessableContentException;
use Browse\Pages\AuthenticatedPage;
use Browse\Providers\MustacheProvider;

class PasswordPage extends AuthenticatedPage {
    protected ?array $allowed_methods = ['GET', 'POST'];
    protected string $title = "Profile";

    protected bool $error = false;

    protected function prepare(): void
    {
        parent::prepare();

        if ($_SERVER['REQUEST_METHOD'] != 'POST')
            return;

        $password = self::filter(INPUT_POST, 'password', required: true);
        $password_check = self::filter(INPUT_POST, 'password_check', required: true);

        if ($password != $password_check) {
            $this->error = true;
            return;
        }

        // i swear to god please don't put zeros in forms...
        // i hate implicit string conversions, who thought it's good idea 🤦
        if (!$password) {
            throw new UnprocessableContentException();
        }

        $this->logged_user->password = hash('sha256', $password);

        Users::update($this->logged_user);
    }

    protected function html_main(): string
    {
        $data = [
            'user' => $this->logged_user
        ];

        if ($this->error) {
            $data['alert'] = MustacheProvider::get()->render('alert', ['alert_type' => 'alert-danger', 'message' => 'Passwords don\'t match']);
        }

        return MustacheProvider::get()->render('password', $data);
    }
}

$page = new PasswordPage();
$page->render();
