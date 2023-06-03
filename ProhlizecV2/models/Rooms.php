<?php

use Browse\Providers\PDOProvider;

class Rooms {
    private static string $table = 'room';

    public ?int $room_id = null;
    public ?string $no = null;
    public ?string $name = null;
    public ?string $phone = null;

    public static function exists(int $room_id) : bool {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE room_id = :room_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':room_id' => $room_id]);

        return count($stmt->fetchAll()) > 0;
    }

    public static function get(int $room_id) : ?Rooms {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE room_id = :room_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':room_id' => $room_id]);
        $data = $stmt->fetch();

        if ($data == null)
            return null;

        return self::instance_from_data($data);
    }

    public static function exists_no(string $no, ?int $except = null) : bool {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE no = :no' . ($except ? ' AND room_id != :room_id' : '');
        $stmt = $pdo->prepare($query);
        $data = [
            ':no' => $no,
        ];
        if ($except)
            $data[':room_id'] = $except;
        $stmt->execute($data);

        return count($stmt->fetchAll()) > 0;
    }

    public static function get_all(?array $order = null) : array {
        $pdo = PDOProvider::get();
        $stmt = $pdo->query('SELECT * FROM `' . self::$table . '`' .
            ($order != null ? OrderBuilder::build($order) : ''));
        return array_map([__CLASS__, 'instance_from_data'], $stmt->fetchAll());
    }

    public static function create(Rooms $room): Rooms {
        $pdo = PDOProvider::get();

        $query = 'INSERT INTO `' . self::$table . '` (no, name, phone) VALUES (:no, :name, :phone)';

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'no' => $room->no,
            'name' => $room->name,
            'phone' => $room->phone,
        ]);

        return self::get($pdo->lastInsertId());
    }

    public static function update(Rooms $room) {
        $pdo = PDOProvider::get();

        $query = 'UPDATE `' . self::$table . '` SET name = :name, no = :no, phone = :phone WHERE room_id = :room_id';

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'room_id' => $room->room_id,
            'no' => $room->no,
            'name' => $room->name,
            'phone' => $room->phone,
        ]);
    }

    public static function delete(int $room_id) {
        $query = 'DELETE FROM `' . self::$table . '` WHERE room_id = :room_id';

        $pdo = PDOProvider::get();

        $stmt = $pdo->prepare($query);
        $stmt->execute(['room_id' => $room_id]);
    }

    private static function instance_from_data(array $data) : Rooms {
        $room = new Rooms();
        $room->room_id = $data['room_id'];
        $room->no = $data['no'];
        $room->name = $data['name'];
        $room->phone = $data['phone'];
        return $room;
    }
}
