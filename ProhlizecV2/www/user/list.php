<?php

require_once "../../bootstrap.php";

use Core\Pages\TablePage;
use Core\Providers\MustacheProvider;

class UsersPage extends TablePage {
    protected string $title = 'Users';

    protected string $heading = 'Users';
    protected array $column_names = ['Username', 'Has Rights'];

    protected function html_table_rows(): array
    {
        return array_map(function ($e) { return MustacheProvider::get()->render('rows/user', [
            'edit' => $this->user->has_rights,
            'user' => $e,
        ]); }, User::get_all());
    }
}

$page = new UsersPage();
$page->render();
