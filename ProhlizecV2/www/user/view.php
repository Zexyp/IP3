<?php

require_once "../../bootstrap.php";

use Browse\Exceptions\NotFoundException;
use Browse\Pages\ViewPage;
use Browse\Providers\MustacheProvider;

class ViewUserPage extends ViewPage {
    protected ?Users $data = null;

    protected function prepare(): void
    {
        parent::prepare();

        if (!Users::exists($this->id))
            throw new NotFoundException();

        $this->data = Users::get($this->id);

        $this->heading = $this->title = $this->data->username;
    }

    protected function html_card(): string
    {
        return MustacheProvider::get()->render('custom/card/user', [
            'user' => $this->data
        ]);
    }
}

$page = new ViewUserPage();
$page->render();
