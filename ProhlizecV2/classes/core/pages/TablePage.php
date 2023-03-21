<?php

namespace Core\Pages;

use Core\Exceptions\BadRequestException;
use Core\Providers\MustacheProvider;

class TablePage extends AuthenticatedPage
{
    protected string $heading = "";
    protected array $columns = [];

    protected ?string $sortby = null;
    protected ?int $sortord = null;

    protected function prepare(): void
    {
        parent::prepare();

        if (isset($_GET['sort'])) {
            if (!str_contains($_GET['sort'], '-'))
                throw new BadRequestException();

            $parts = explode('-', $_GET['sort'], 2);
            $plausible = array_map(function ($e) { return $e['id']; },  $this->columns);
            if (!in_array($parts[0], $plausible) or !in_array($parts[1], ['a', 'd']))
                throw new BadRequestException();

            $this->sortby = $parts[0];

            if ($parts[1] == 'a')
                $this->sortord = -1;
            if ($parts[1] == 'd')
                $this->sortord = 1;
        }
    }

    protected function html_main(): string
    {
        $cols = array_map(function ($e) {
                return MustacheProvider::get()->render('table/header', [
                    'name' => $e['name'],
                    'sort_id' => $e['id'],
                    'sort_a' => $e['id'] == $this->sortby and $this->sortord < 0,
                    'sort_d' => $e['id'] == $this->sortby and $this->sortord > 0]);
            }, $this->columns);

        $rows = $this->html_table_rows();

        $data = [
            'heading' => $this->heading,
            'thead' => implode($cols),
            'tbody' => implode($rows),
            'edit' => $this->user->has_rights
        ];

        return MustacheProvider::get()->render('table/main', $data);
    }

    protected function html_table_rows() : array {
        return [];
    }
}