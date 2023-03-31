<?php

namespace Browse\Pages;

use Browse\Exceptions\UnprocessableContentException;
use Browse\Providers\MustacheProvider;

abstract class EditPage extends AdminPage
{
    const MODE_NONE = 0;
    const MODE_UPDATE = 1;
    const MODE_CREATE = 2;
    const MODE_DELETE = 3;

    protected ?array $allowed_methods = ['GET', 'POST'];

    protected string $heading = '';
    protected ?int $id = null;
    protected int $mode = self::MODE_NONE;

    protected function prepare(): void
    {
        parent::prepare();

        $this->mode = self::MODE_UPDATE;
        if (isset($_GET['mode'])) {
            if (!in_array($_GET['mode'], ['update', 'create', 'delete']))
                throw new UnprocessableContentException();

            switch ($_GET['mode']) {
                case 'update': $this->mode = self::MODE_UPDATE; break;
                case 'create': $this->mode = self::MODE_CREATE; break;
                case 'delete': $this->mode = self::MODE_DELETE; break;
                default: assert(false); break;
            }
        }

        if (in_array($this->mode, [self::MODE_UPDATE, self::MODE_DELETE])) {
            $this->id = self::filter(INPUT_GET, 'id', FILTER_VALIDATE_INT, true);
        }

        switch ($this->mode) {
            case self::MODE_UPDATE: $this->title = $this->heading = 'Edit'; break;
            case self::MODE_CREATE: $this->title = $this->heading = 'Create'; break;
            case self::MODE_DELETE: $this->title = $this->heading = 'Delete'; break;
        }

        $this->title .= ': ' . $this->get_object_name();

        if (!$this->poll()) // just checkin'
            return;

        if (in_array($this->mode, [self::MODE_UPDATE, self::MODE_CREATE])) {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET': $this->data_get(); break;
                case 'POST':
                {
                    $this->data_post();
                    if ($this->validate_data()) {
                        switch ($this->mode) {
                            case self::MODE_UPDATE: $this->update(); break;
                            case self::MODE_CREATE: $this->create(); break;
                        }
                    }
                } break;
                default: assert(false); break;
            }

        }

        if ($this->mode == self::MODE_DELETE)
            $this->delete();
    }

    protected function html_main(): string
    {
        return MustacheProvider::get()->render('edit', [
            'alert' => $this->html_alert(),
            'heading' => $this->heading,
            'name' => $this->get_object_name(),
            'form' => in_array($this->mode, [self::MODE_CREATE, self::MODE_UPDATE]) ? $this->html_form() : '',
            'id' => $this->id,
            'create' => $this->mode == self::MODE_CREATE,
            'delete' => $this->mode == self::MODE_DELETE,
        ]);
    }

    protected function html_alert(): string {
        return '';
    }

    protected function poll(): bool {
        return true;
    }

    protected function get_object_name(): string {
        return '';
    }

    protected abstract function html_form(): string;

    protected abstract function data_get();

    protected abstract function data_post();

    protected abstract function validate_data(): bool;

    protected abstract function create();
    protected abstract function update();
    protected abstract function delete();
}