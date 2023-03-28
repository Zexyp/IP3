<?php

require_once "../../bootstrap.php";

use Browse\Exceptions\NotFoundException;
use Browse\Exceptions\NotImplementedException;
use Browse\Exceptions\UnprocessableContentException;
use Browse\Pages\EditPage;
use Browse\Providers\MustacheProvider;

class EditUserPage extends EditPage {
    protected Users $user;

    protected string $error = '';

    protected function html_form(): string
    {
        return MustacheProvider::get()->render('custom/form/user', [
            'user' => $this->user,
        ]);
    }

    protected function html_alert(): string
    {
        return $this->error;
    }

    protected function data_get()
    {
        switch ($this->mode) {
            case self::MODE_UPDATE:
            {
                $this->user = Users::get($this->id);
            }
            break;
            case self::MODE_CREATE:
            {
                $this->user = new Users();
            }
            break;
            default: assert(false); break;
        }
    }

    protected function data_post()
    {
        switch ($this->mode) {
            case self::MODE_UPDATE: $this->user = Users::get($this->id); break;
            case self::MODE_CREATE: $this->user = new Users(); break;
            default: assert(false); break;
        }

        $this->user->username = self::filter(INPUT_POST, 'username', required: true);
        $p = self::filter(INPUT_POST, 'password', required: true);
        $this->user->password = $p ? hash('sha256', $p) : $this->user->password;
        $this->user->has_rights = self::filter(INPUT_POST, 'has_rights', FILTER_VALIDATE_INT, false) > 0;
    }

    protected function validate_data(): bool
    {
        if (Users::exists_username($this->user->username)) {
            if ($this->mode == self::MODE_CREATE) {
                $this->error .= MustacheProvider::get()->render('alert', ['alert_type' => 'alert-danger', 'message' => 'Login already used!']);
                return false;
            }
            if ($this->mode == self::MODE_UPDATE and Users::get_all_username($this->user->username)[0]->user_id != $this->user->user_id) {
                $this->error .= MustacheProvider::get()->render('alert', ['alert_type' => 'alert-danger', 'message' => 'Login already used!']);
                return false;
            }
        }


        if (!$this->user->password) {
            $this->error .= MustacheProvider::get()->render('alert', ['alert_type' => 'alert-danger', 'message' => 'Password needs to be set!']);
            return false;
        }
        if (!$this->user->username)
            throw new UnprocessableContentException();

        return true;
    }

    protected function create()
    {
        $this->user = Users::create($this->user);
        $this->id = $this->user->user_id;

        self::redirect("view.php?id={$this->id}");
    }

    protected function update()
    {
        Users::update($this->user);

        self::redirect("view.php?id={$this->id}");
    }

    protected function delete()
    {
        Users::delete($this->id);

        self::redirect('list.php');
    }

    protected function poll()
    {
        if (!in_array($this->mode, [self::MODE_UPDATE, self::MODE_DELETE]))
            return;

        if (!Users::exists($this->id))
            throw new NotFoundException();
    }
}

$page = new EditUserPage();
$page->render();
