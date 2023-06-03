<?php

require_once "../../bootstrap.php";

use Browse\Pages\TablePage;
use Browse\Providers\MustacheProvider;

class ListEmployeePage extends TablePage {
    protected string $title = 'Employees';

    protected string $heading = 'Employees';
    protected array $columns = [
        [
            'name' => 'Name',
            'id' => 'name'
        ],
        [
            'name' => 'Surname',
            'id' => 'surname'
        ],
        [
            'name' => 'Job',
            'id' => 'job'
        ],
        [
            'name' => 'Wage',
            'id' => 'wage'
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
                'data' => MustacheProvider::get()->render('custom/row/employee', [
                    'edit' => $this->logged_user->has_rights,
                    'employee' => $e,
                    'room' => $e->get_room()]),
                'id' => $e->employee_id
            ]; },
            Employees::get_all(order: $this->sortby != null ? [[$this->sortby, $this->sortord]] : null));
    }
}

$page = new ListEmployeePage();
$page->render();
