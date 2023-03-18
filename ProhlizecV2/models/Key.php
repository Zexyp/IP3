<?php

use Core\Providers\PDOProvider;

class Key {
    private static string $table = 'key';

    public int $key_id;
    public ?string $employee;
    public ?string $room;

    public function get_room() : Room {
        return Room::get($this->room);
    }

    public function get_employee() : Employee {
        return Employee::get($this->employee);
    }

    public static function get($key_id) : ?Key {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE key_id = :key_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':key_id' => $key_id]);
        $data = $stmt->fetch();

        if ($data == null)
            return null;

        return self::instance_from_data($data);
    }

    public static function get_all() : array {
        $pdo = PDOProvider::get();
        $stmt = $pdo->query('SELECT * FROM `' . self::$table . '`');
        return array_map([__CLASS__, 'instance_from_data'], $stmt->fetchAll());
    }

    private static function instance_from_data($data) : Key {
        $key = new Key();
        $key->employee = $data['employee'];
        $key->room = $data['room'];
        return $key;
    }
}
