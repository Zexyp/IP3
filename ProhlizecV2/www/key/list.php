<?php

require_once "../../bootstrap.php";

use Browse\Pages\TablePage;
use Browse\Providers\MustacheProvider;

class ListKeyPage extends TablePage {
    protected string $title = 'Keys';

    protected string $heading = 'Keys';
    protected array $columns = [
        [
            'name' => 'Employee',
            'id' => 'employee'
        ],
        [
            'name' => 'Room',
            'id' => 'room'
        ]
    ];

    protected function get_table_data(): array
    {
        return array_map(function ($e) {
            return [
                'data' => MustacheProvider::get()->render('custom/row/key', [
                    'key' => $e,
                    'room' => $e->get_room(),
                    'employee' => $e->get_employee()]),
                'id' => $e->key_id
            ]; },
            Keys::get_all(order: $this->sortby != null ? [[$this->sortby, $this->sortord]] : null));
    }
}

$page = new ListKeyPage();
$page->render();
