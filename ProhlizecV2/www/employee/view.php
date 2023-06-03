<?php

require_once "../../bootstrap.php";

use Browse\Exceptions\NotFoundException;
use Browse\Pages\ViewPage;
use Browse\Providers\MustacheProvider;

class ViewEmployeePage extends ViewPage {
    protected ?Employees $data = null;

    protected function prepare(): void
    {
        parent::prepare();

        if (!Employees::exists($this->id))
            throw new NotFoundException();

        $this->data = Employees::get($this->id);

        $this->heading = $this->title = "{$this->data->name} {$this->data->surname}";
    }

    protected function html_card(): string
    {
        return MustacheProvider::get()->render('custom/card/employee', [
            'employee' => $this->data,
            'room' => $this->data->get_room(),
            'keys' => array_map(function ($e) { return $e->get_room(); }, Keys::of_employee($this->data->employee_id))
        ]);
    }
}

$page = new ViewEmployeePage();
$page->render();
