<?php

require_once "../../bootstrap.php";

use Core\Pages\TablePage;
use Core\Providers\MustacheProvider;

class RoomsPage extends TablePage {
    protected string $title = 'Rooms';

    protected string $heading = 'Rooms';
    protected array $columns = [
        [
            'name' => 'No',
            'id' => 'no'
        ],
        [
            'name' => 'Name',
            'id' => 'name'
        ],
        [
            'name' => 'Phone',
            'id' => 'phone'
        ]
    ];

    protected function html_table_rows(): array
    {
        return array_map(function ($e) { return MustacheProvider::get()->render('custom/row/room', [
            'edit' => $this->user->has_rights,
            'room' => $e,
        ]); }, Room::get_all(order: $this->sortby != null ? [[$this->sortby, $this->sortord]] : null));
    }
}

$page = new RoomsPage();
$page->render();
