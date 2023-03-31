<?php

require_once "../../bootstrap.php";

use Browse\Exceptions\NotFoundException;
use Browse\Exceptions\NotImplementedException;
use Browse\Exceptions\UnprocessableContentException;
use Browse\Pages\EditPage;
use Browse\Providers\MustacheProvider;

class EditKeyPage extends EditPage {
    protected Keys $key;

    protected string $error = '';

    protected function html_form(): string
    {
        return MustacheProvider::get()->render('custom/form/key', [
            'employees' => array_map(function ($e) {
                $e->selected = $e->employee_id == $this->key->employee;
                return $e;
            }, Employees::get_all()),
            'rooms' => array_map(function ($e) {
                $e->selected = $e->room_id == $this->key->room;
                return $e;
            }, Rooms::get_all()),
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
                $this->key = Keys::get($this->id);
            }
            break;
            case self::MODE_CREATE:
            {
                $this->key = new Keys();
            }
            break;
            default: assert(false); break;
        }
    }

    protected function data_post()
    {
        switch ($this->mode) {
            case self::MODE_UPDATE: $this->key = Keys::get($this->id); break;
            case self::MODE_CREATE: $this->key = new Keys(); break;
            default: assert(false); break;
        }

        $this->key->employee = self::filter(INPUT_POST, 'employee', FILTER_VALIDATE_INT, true);
        $this->key->room = self::filter(INPUT_POST, 'room', FILTER_VALIDATE_INT, true);
    }

    protected function validate_data(): bool
    {
        if (!Employees::exists($this->key->employee))
            throw new UnprocessableContentException();

        if (!Rooms::exists($this->key->room))
            throw new UnprocessableContentException();

        if (Keys::exists_pair($this->key->employee, $this->key->room)) {
            $this->error .= MustacheProvider::get()->render('alert', ['alert_type' => 'alert-danger', 'message' => 'Key already exists!']);
            return false;
        }

        return true;
    }

    protected function create()
    {
        $this->key = Keys::create($this->key);
        $this->id = $this->key->key_id;

        self::redirect("view.php?id={$this->id}");
    }

    protected function update()
    {
        Keys::update($this->key);

        self::redirect("view.php?id={$this->id}");
    }

    protected function delete()
    {
        Keys::delete($this->id);

        self::redirect('list.php');
    }

    protected function poll(): bool
    {
        if (!in_array($this->mode, [self::MODE_UPDATE, self::MODE_DELETE]))
            return true;

        if (!Keys::exists($this->id))
            throw new NotFoundException();

        return true;
    }

    protected function get_object_name(): string
    {
        if (!$this->id) return 'Key';
        $obj = Keys::get($this->id);
        if (!$obj)
            return '';
        $employee = $obj->get_employee();
        $room = $obj->get_room();
        return "{$employee->name} {$employee->surname}'s key to {$room->name} ({$room->no})";
    }
}

$page = new EditKeyPage();
$page->render();
