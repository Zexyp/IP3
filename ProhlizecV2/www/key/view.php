<?php

require_once "../../bootstrap.php";

use Browse\Exceptions\NotFoundException;
use Browse\Pages\ViewPage;
use Browse\Providers\MustacheProvider;

class ViewKeyPage extends ViewPage {
    protected ?Keys $data = null;

    protected function prepare(): void
    {
        parent::prepare();

        if (!Keys::exists($this->id))
            throw new NotFoundException();

        $this->data = Keys::get($this->id);

        $employee = $this->data->get_employee();
        $room = $this->data->get_room();
        $this->heading = $this->title = "{$employee->name} {$employee->surname}'s key to {$room->name} ({$room->no})";
    }

    protected function html_card(): string
    {
        return MustacheProvider::get()->render('custom/card/key', [
            'key' =>  $this->data,
            'employee' => $this->data->get_employee(),
            'room' => $this->data->get_room(),
        ]);
    }
}

$page = new ViewKeyPage();
$page->render();
