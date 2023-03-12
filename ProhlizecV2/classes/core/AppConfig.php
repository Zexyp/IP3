<?php

namespace Core;

use Noodlehaus\Config;

class AppConfig
{
    private static ?Config $instance = null;
    public static function get(string $key)
    {
        if (!self::$instance)
            self::createInstance();

        return self::$instance->get($key);
    }

    private static function createInstance() : void
    {
        self::$instance = Config::load(["../config/config.json"]);
    }
}