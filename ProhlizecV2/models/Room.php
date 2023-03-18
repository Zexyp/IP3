<?php

use Core\Providers\PDOProvider;

class Room {
    private static string $table = 'room';

    public int $room_id;
    public ?string $no;
    public ?string $name;
    public ?string $phone;

    public static function get($room_id) : ?Room {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE room_id = :room_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':room_id' => $room_id]);
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

    private static function instance_from_data($data) : Room {
        $room = new Room();
        $room->no = $data['no'];
        $room->name = $data['name'];
        $room->phone = $data['phone'];
        return $room;
    }
}
