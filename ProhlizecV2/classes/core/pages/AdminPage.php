<?php

namespace Core\Pages;

use Core\Exceptions\ForbiddenException;

class AdminPage extends AuthenticatedPage
{
    protected function prepare(): void
    {
        parent::prepare();

        if (!$this->user->has_rights)
            throw new ForbiddenException();
    }
}