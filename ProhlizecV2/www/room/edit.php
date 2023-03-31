<?php

require_once "../../bootstrap.php";

use Browse\Exceptions\NotFoundException;
use Browse\Exceptions\NotImplementedException;
use Browse\Exceptions\UnprocessableContentException;
use Browse\Pages\EditPage;
use Browse\Providers\MustacheProvider;

class EditRoomPage extends EditPage {
    protected Rooms $room;
    protected array $keys;

    protected string $error = '';

    protected function html_form(): string
    {
        return MustacheProvider::get()->render('custom/form/room', [
            'room' => $this->room,
        ]);
    }

    protected function html_alert(): string
    {
        return $this->error;
    }

    protected function data_get()
    {
        switch ($this->mode) {
            case self::MODE_UPDATE:
            {
                $this->room = Rooms::get($this->id);
            }
            break;
            case self::MODE_CREATE:
            {
                $this->room = new Rooms();
            }
            break;
            default: assert(false); break;
        }
    }

    protected function data_post()
    {
        switch ($this->mode) {
            case self::MODE_UPDATE: $this->room = Rooms::get($this->id); break;
            case self::MODE_CREATE: $this->room = new Rooms(); break;
            default: assert(false); break;
        }

        $this->room->no = self::filter(INPUT_POST, 'no', FILTER_VALIDATE_INT, true);
        $this->room->name = self::filter(INPUT_POST, 'name', required: true);
        $this->room->phone = self::filter(INPUT_POST, 'phone', FILTER_VALIDATE_INT, false);
    }

    protected function validate_data(): bool
    {
        return true;
    }

    protected function create()
    {
        $this->room = Rooms::create($this->room);
        $this->id = $this->room->room_id;

        self::redirect("view.php?id={$this->id}");
    }

    protected function update()
    {
        Rooms::update($this->room);

        self::redirect("view.php?id={$this->id}");
    }

    protected function delete()
    {
        Rooms::delete($this->id);

        self::redirect('list.php');
    }

    protected function poll()
    {
        if (!in_array($this->mode, [self::MODE_UPDATE, self::MODE_DELETE]))
            return;

        if (!Rooms::exists($this->id))
            throw new NotFoundException();
    }
}

$page = new EditRoomPage();
$page->render();
