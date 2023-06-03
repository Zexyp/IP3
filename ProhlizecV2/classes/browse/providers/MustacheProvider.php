<?php

namespace Browse\Providers;

use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class MustacheProvider
{
    private static ?Mustache_Engine $instance = null;

    public static function get() : Mustache_Engine
    {
        if (!self::$instance)
            self::createInstance();

        return self::$instance;
    }

    private static function createInstance() : void
    {
        self::$instance = new Mustache_Engine([
            'entity_flags' => ENT_QUOTES,
            'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . "/../../../templates")
        ]);
    }
}