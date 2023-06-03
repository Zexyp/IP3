<?php

require_once "../../bootstrap.php";

use Browse\Exceptions\NotFoundException;
use Browse\Exceptions\NotImplementedException;
use Browse\Exceptions\UnprocessableContentException;
use Browse\Pages\EditPage;
use Browse\Providers\MustacheProvider;

class EditEmployeePage extends EditPage {
    protected Employees $employee;
    protected array $keys;

    protected function html_form(): string
    {
        $rooms = Rooms::get_all();

        return MustacheProvider::get()->render('custom/form/employee', [
            'employee' => $this->employee,
            'rooms' => array_map(function ($e) {
                $e->selected = $e->room_id == $this->employee->room;
                return $e;
            }, $rooms),
            'keys' => array_map(function ($e) {
                $e->checked = in_array($e->room_id, $this->keys);
                return $e;
            }, $rooms)
        ]);
    }

    protected function data_get()
    {
        switch ($this->mode) {
            case self::MODE_UPDATE:
            {
                $this->employee = Employees::get($this->id);
                $this->keys = array_map(function ($e) { return $e->room; }, Keys::of_employee($this->employee->employee_id));
            }
            break;
            case self::MODE_CREATE:
            {
                $this->employee = new Employees();
                $this->keys = [];
            }
            break;
            default: assert(false); break;
        }
    }

    protected function data_post()
    {
        switch ($this->mode) {
            case self::MODE_UPDATE: $this->employee = Employees::get($this->id); break;
            case self::MODE_CREATE: $this->employee = new Employees(); break;
            default: assert(false); break;
        }

        $this->employee->name = self::filter(INPUT_POST, 'name', required: false);
        $this->employee->surname = self::filter(INPUT_POST, 'surname', required: false);
        $this->employee->job = self::filter(INPUT_POST, 'job', required: false);
        $this->employee->wage = self::filter(INPUT_POST, 'wage', FILTER_VALIDATE_INT, true);
        $this->employee->room = self::filter(INPUT_POST, 'room', FILTER_VALIDATE_INT, false);

        $this->keys = self::filter(INPUT_POST, 'keys', FILTER_VALIDATE_INT, false, FILTER_REQUIRE_ARRAY) ??
            [];
    }

    protected function validate_data(): bool
    {
        if (!Rooms::exists($this->employee->room))
            throw new UnprocessableContentException();

        foreach ($this->keys as $k) {
            if (!Rooms::exists($k))
                throw new UnprocessableContentException();
        }

        return true;
    }

    protected function create()
    {
        $this->employee = Employees::create($this->employee);
        $this->id = $this->employee->employee_id;

        foreach ($this->keys as $rid) {
            $k = new Keys();
            $k->room = $rid;
            $k->employee = $this->id;
            Keys::create($k);
        }

        self::redirect("view.php?id={$this->id}");
    }

    protected function update()
    {
        Employees::update($this->employee);

        $todel = Keys::of_employee($this->id);
        foreach ($todel as $k) {
            Keys::delete($k->key_id);
        }

        foreach ($this->keys as $rid) {
            $k = new Keys();
            $k->room = $rid;
            $k->employee = $this->id;
            Keys::create($k);
        }

        self::redirect("view.php?id={$this->id}");
    }

    protected function delete()
    {
        $todel = Keys::of_employee($this->id);
        foreach ($todel as $k) {
            Keys::delete($k->key_id);
        }

        Employees::delete($this->id);

        self::redirect('list.php');
    }

    protected function poll(): bool
    {
        if (!in_array($this->mode, [self::MODE_UPDATE, self::MODE_DELETE]))
            return true;

        if (!Employees::exists($this->id))
            throw new NotFoundException();

        return true;
    }

    protected function get_object_name(): string
    {
        if (!$this->id) return 'Employee';
        $obj = Employees::get($this->id);
        if (!$obj)
            return '';
        return "{$obj->name} {$obj->surname}";
    }
}

$page = new EditEmployeePage();
$page->render();
