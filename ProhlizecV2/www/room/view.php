<?php

require_once "../../bootstrap.php";

use Browse\Exceptions\NotFoundException;
use Browse\Pages\ViewPage;
use Browse\Providers\MustacheProvider;

class ViewRoomPage extends ViewPage {
    protected ?Rooms $data = null;

    protected function prepare(): void
    {
        parent::prepare();

        if (!Rooms::exists($this->id))
            throw new NotFoundException();

        $this->data = Rooms::get($this->id);

        $this->heading = $this->title = "{$this->data->name} ({$this->data->no})";
    }

    protected function html_card(): string
    {
        return MustacheProvider::get()->render('custom/card/room', [
            'room' => $this->data,
            'employees' => Employees::of_room($this->data->room_id),
            'keys' => array_map(function ($e) { return $e->get_employee(); }, Keys::of_room($this->data->room_id)),
        ]);
    }
}

$page = new ViewRoomPage();
$page->render();
