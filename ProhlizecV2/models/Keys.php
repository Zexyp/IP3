<?php

use Browse\Providers\PDOProvider;

class Keys {
    private static string $table = 'key';

    public ?int $key_id = null;
    public ?string $employee = null;
    public ?string $room = null;

    public function get_room() : Rooms {
        return Rooms::get($this->room);
    }

    public function get_employee() : Employees {
        return Employees::get($this->employee);
    }

    public static function of_room(int $room_id) : array {
        $pdo = PDOProvider::get();
        $stmt = $pdo->prepare('SELECT * FROM `' . self::$table . '` WHERE room = :room');
        $stmt->execute([':room' => $room_id]);

        return array_map([__CLASS__, 'instance_from_data'], $stmt->fetchAll());
    }

    public static function of_employee(int $employee_id) : array {
        $pdo = PDOProvider::get();
        $stmt = $pdo->prepare('SELECT * FROM `' . self::$table . '` WHERE employee = :employee');
        $stmt->execute([':employee' => $employee_id]);

        return array_map([__CLASS__, 'instance_from_data'], $stmt->fetchAll());
    }

    public static function exists(int $key_id) : bool {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE key_id = :key_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':key_id' => $key_id]);

        return count($stmt->fetchAll()) > 0;
    }

    public static function exists_pair(int $employee_id, int $room_id) : bool {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE employee = :employee AND room = :room';
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':employee' => $employee_id,
            ':room' => $room_id,
        ]);

        return count($stmt->fetchAll()) > 0;
    }

    public static function get(int $key_id) : ?Keys {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE key_id = :key_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':key_id' => $key_id]);
        $data = $stmt->fetch();

        if ($data == null)
            return null;

        return self::instance_from_data($data);
    }

    public static function get_all(?array $order = null) : array {
        $pdo = PDOProvider::get();
        $stmt = $pdo->query('SELECT * FROM `' . self::$table . '`' .
            ($order != null ? OrderBuilder::build($order) : ''));
        return array_map([__CLASS__, 'instance_from_data'], $stmt->fetchAll());
    }

    public static function create(Keys $key): Keys {
        $pdo = PDOProvider::get();

        $query = 'INSERT INTO `' . self::$table . '` (employee, room) VALUES (:employee, :room)';

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'employee' => $key->employee,
            'room' => $key->room,
        ]);

        return self::get($pdo->lastInsertId());
    }

    public static function update(Keys $key) {
        $pdo = PDOProvider::get();

        $query = 'UPDATE `' . self::$table . '` SET employee = :employee, room = :room WHERE key_id = :key_id';

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'key_id' => $key->key_id,
            'employee' => $key->employee,
            'room' => $key->room,
        ]);
    }

    public static function delete(int $key_id) {
        $query = 'DELETE FROM `' . self::$table . '` WHERE key_id = :key_id';

        $pdo = PDOProvider::get();

        $stmt = $pdo->prepare($query);
        $stmt->execute(['key_id' => $key_id]);
    }

    private static function instance_from_data(array $data) : Keys {
        $key = new Keys();
        $key->key_id = $data['key_id'];
        $key->employee = $data['employee'];
        $key->room = $data['room'];
        return $key;
    }
}
