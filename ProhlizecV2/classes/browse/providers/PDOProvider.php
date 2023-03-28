<?php

namespace Browse\Providers;

use Browse\AppConfig;
use PDO;

class PDOProvider
{
    private static ?PDO $instance = null;

    public static function get() : PDO
    {
        if (!self::$instance)
            self::createInstance();

        return self::$instance;
    }

    private static function createInstance() : void
    {
        $host = AppConfig::get('db.host');
        $port = AppConfig::get('db.port');
        $database = AppConfig::get('db.database');
        $username = AppConfig::get('db.username');
        $password = AppConfig::get('db.password');
        $charset = AppConfig::get('db.charset');

        $dsn = "mysql:host=$host;dbname=$database;charset=$charset;port=$port";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        self::$instance = new PDO($dsn, $username, $password, $options);
    }
}