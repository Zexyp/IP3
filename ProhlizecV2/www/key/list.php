<?php

require_once "../../bootstrap.php";

use Core\Pages\TablePage;
use Core\Providers\MustacheProvider;

class KeysPage extends TablePage {
    protected string $title = 'Keys';

    protected string $heading = 'Keys';
    protected array $column_names = ['Employee', 'Room'];

    protected function html_table_rows(): array
    {
        return array_map(function ($e) { return MustacheProvider::get()->render('rows/key', [
            'edit' => $this->user->has_rights,
            'key' => $e,
            'room' => $e->get_room(),
            'employee' => $e->get_employee(),
        ]); }, Key::get_all());
    }
}

$page = new KeysPage();
$page->render();
