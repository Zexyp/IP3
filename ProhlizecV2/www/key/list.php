<?php

require_once "../../bootstrap.php";

use Core\Pages\TablePage;
use Core\Providers\MustacheProvider;

class KeysPage extends TablePage {
    protected string $title = 'Keys';

    protected string $heading = 'Keys';
    protected array $columns = [
        [
            'name' => 'Room',
            'id' => 'room'
        ],
        [
            'name' => 'Employee',
            'id' => 'employee'
        ]
    ];

    protected function html_table_rows(): array
    {
        return array_map(function ($e) { return MustacheProvider::get()->render('custom/row/key', [
            'edit' => $this->user->has_rights,
            'key' => $e,
            'room' => $e->get_room(),
            'employee' => $e->get_employee(),
        ]); }, Key::get_all(order: $this->sortby != null ? [[$this->sortby, $this->sortord]] : null));
    }
}

$page = new KeysPage();
$page->render();
