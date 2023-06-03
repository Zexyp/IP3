<?php

require_once __DIR__ . "/vendor/autoload.php";

spl_autoload_register(
    function ($class_name) {
        $lmao = explode('\\', $class_name);
        $path = strtolower(implode('/', array_slice($lmao, 0, count($lmao) - 1)));
        $name = end($lmao);
        $filepath = __DIR__ . "/classes/$path/$name.php";
        if (file_exists($filepath))
            include $filepath;
    }
);

spl_autoload_register(
    function ($class_name) {
        $filepath = __DIR__ . "/models/$class_name.php";
        if (file_exists($filepath))
            include $filepath;
    }
);

use Browse\AppConfig;
use Tracy\Debugger;

if (AppConfig::get('debug'))
    Debugger::enable(Debugger::Development);
