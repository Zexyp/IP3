<?php

namespace Core\Pages;

use Core\Providers\MustacheProvider;

class TablePage extends AuthenticatedPage
{
    protected string $heading = "";
    protected array $column_names = [];
    protected array $data = [];

    protected function html_main(): string
    {
        $cols = array_map(function ($e) { return "<th scope=\"col\">$e</th>"; }, $this->column_names);
        $rows = array_map(function ($e) { return '<tr>' . $e . '</tr>'; }, $this->html_table_rows());

        $data = [
            'heading' => $this->heading,
            'thead' => implode($cols),
            'tbody' => implode($rows),
            'edit' => $this->user->has_rights
        ];

        return MustacheProvider::get()->render('table', $data);
    }

    protected function html_table_rows() : array {
        return [];
    }
}