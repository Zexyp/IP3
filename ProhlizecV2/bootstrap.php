<?php

require_once __DIR__ . "/vendor/autoload.php";

spl_autoload_register(
    function ($class_name) {
        $lmao = explode('\\', $class_name);
        $path = strtolower(implode('/', array_slice($lmao, 0, count($lmao) - 1)));
        $name = end($lmao);
        include __DIR__ . "/classes/{$path}/$name.php";
    }
);

spl_autoload_register(
    function ($class_name) {
        include __DIR__ . "/models/{$class_name}.php";
    }
);

use Tracy\Debugger;
Debugger::enable(Debugger::DEVELOPMENT);
