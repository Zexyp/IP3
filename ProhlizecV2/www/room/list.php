<?php

require_once "../../bootstrap.php";

use Browse\Pages\TablePage;
use Browse\Providers\MustacheProvider;

class ListRoomPage extends TablePage {
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

    protected function get_table_data(): array
    {
        return array_map(function ($e) {
            return [
                'data' => MustacheProvider::get()->render('custom/row/room', [
                    'room' => $e]),
                'id' => $e->room_id
            ]; },
            Rooms::get_all(order: $this->sortby != null ? [[$this->sortby, $this->sortord]] : null));
    }
}

$page = new ListRoomPage();
$page->render();
