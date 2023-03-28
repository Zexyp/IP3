<?php

namespace Browse\Pages;

use Browse\Exceptions\ForbiddenException;

abstract class AdminPage extends AuthenticatedPage
{
    protected function prepare(): void
    {
        parent::prepare();

        if (!$this->logged_user->has_rights)
            throw new ForbiddenException();
    }
}