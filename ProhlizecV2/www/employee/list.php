<?php

require_once "../../bootstrap.php";

use Core\Pages\TablePage;
use Core\Providers\MustacheProvider;

class EmployeesPage extends TablePage {
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

    protected function html_table_rows(): array
    {
        return array_map(function ($e) { return MustacheProvider::get()->render('custom/row/employee', [
            'edit' => $this->user->has_rights,
            'employee' => $e,
            'room' => $e->get_room(),
        ]); }, Employee::get_all(order: $this->sortby != null ? [[$this->sortby, $this->sortord]] : null));
    }
}

$page = new EmployeesPage();
$page->render();
