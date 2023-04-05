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
        $this->room->name = self::filter(INPUT_POST, 'name', required: false);
        $this->room->phone = self::filter(INPUT_POST, 'phone', FILTER_VALIDATE_INT, false);
    }

    protected function validate_data(): bool
    {
        if (Rooms::exists_no($this->room->no, $this->room->room_id)) {
            $this->error .= MustacheProvider::get()->render('alert', [
                'alert_type' => 'alert-danger',
                'message' => 'No already exists!',
            ]);
            return false;
        }

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

    protected function poll(): bool
    {
        if (!in_array($this->mode, [self::MODE_UPDATE, self::MODE_DELETE]))
            return true;

        if (!Rooms::exists($this->id))
            throw new NotFoundException();

        if ($this->mode != self::MODE_DELETE)
            return true;

        $employees = Employees::of_room($this->id);
        foreach ($employees as $employee) {
            $this->error .= MustacheProvider::get()->render('alert', [
                'alert_type' => 'alert-danger',
                'message_before' => 'Employee ',
                'message_after' => ' lives in this very room!',
                'link' => [
                    'href' => "../employee/view.php?id=$employee->employee_id",
                    'title' => "$employee->name $employee->surname",
                ]]);
            http_response_code(422);
        }

        $keys = Keys::of_room($this->id);
        foreach ($keys as $key) {
            $employee = $key->get_employee();
            $this->error .= MustacheProvider::get()->render('alert', [
                'alert_type' => 'alert-danger',
                'message_before' => 'Employee ',
                'message_after' => ' uses this room!',
                'link' => [
                    'href' => "../employee/view.php?id=$employee->employee_id",
                    'title' => "$employee->name $employee->surname",
                ]]);
            http_response_code(422);
        }
        return !count($employees) && !count($keys);
    }

    protected function get_object_name(): string
    {
        if (!$this->id) return 'Room';
        $obj = Rooms::get($this->id);
        if (!$obj)
            return '';
        return "{$obj->name} ({$obj->no})";
    }
}

$page = new EditRoomPage();
$page->render();
