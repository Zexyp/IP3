<?php

require_once "../../bootstrap.php";

use Browse\Pages\TablePage;
use Browse\Providers\MustacheProvider;

class ListUserPage extends TablePage {
    protected string $title = 'Users';

    protected string $heading = 'Users';
    protected array $columns = [
        [
            'name' => 'Username',
            'id' => 'username'
        ],
        [
            'name' => 'Has Rights',
            'id' => 'rights'
        ]
    ];

    protected function get_table_data(): array
    {
        return array_map(function ($e) {
            return [
                'data' => MustacheProvider::get()->render('custom/row/user', [
                    'user' => $e,]),
                'id' => $e->user_id
            ]; },
            Users::get_all(order: $this->sortby != null ? [[$this->sortby, $this->sortord]] : null));
    }
}

$page = new ListUserPage();
$page->render();
