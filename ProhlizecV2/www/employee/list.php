<?php

require_once "../../bootstrap.php";

use Core\Pages\TablePage;
use Core\Providers\MustacheProvider;

class EmployeesPage extends TablePage {
    protected string $title = 'Employees';

    protected string $heading = 'Employees';
    protected array $column_names = ['Name', 'Surname', 'Job', 'Wage', 'Room'];

    protected function html_table_rows(): array
    {
        return array_map(function ($e) { return MustacheProvider::get()->render('rows/employee', [
            'edit' => $this->user->has_rights,
            'employee' => $e,
            'room' => $e->get_room(),
        ]); }, Employee::get_all());
    }
}

$page = new EmployeesPage();
$page->render();
