<?php

require_once "../../bootstrap.php";

use Core\Pages\TablePage;
use Core\Providers\MustacheProvider;

class RoomsPage extends TablePage {
    protected string $title = 'Rooms';

    protected string $heading = 'Rooms';
    protected array $column_names = ['No', 'Name', 'Phone'];

    protected function html_table_rows(): array
    {
        return array_map(function ($e) { return MustacheProvider::get()->render('rows/room', [
            'edit' => $this->user->has_rights,
            'room' => $e,
        ]); }, Room::get_all());
    }
}

$page = new RoomsPage();
$page->render();
