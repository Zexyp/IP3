<?php

namespace Browse\Pages;

use Browse\Providers\MustacheProvider;

abstract class ViewPage extends AuthenticatedPage
{
    protected string $heading = '';
    protected ?int $id;

    protected function prepare(): void
    {
        parent::prepare();

        $this->id = self::filter(INPUT_GET, 'id', FILTER_VALIDATE_INT, true);
    }

    protected function html_main(): string
    {
        return MustacheProvider::get()->render('view', [
            'heading' => $this->heading,
            'card' => $this->html_card(),
            'edit' => $this->logged_user->has_rights,
            'id' => $this->id
        ]);
    }

    protected abstract function html_card(): string;
}