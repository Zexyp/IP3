<?php

use Browse\Providers\PDOProvider;

class Employees {
    private static string $table = 'employee';

    public ?int $employee_id = null;
    public ?string $name = null;
    public ?string $surname = null;
    public ?string $job = null;
    public ?string $wage = null;
    public ?string $room = null;

    public function get_room() : Rooms {
        return Rooms::get($this->room);
    }

    public static function of_room(int $room_id) : array {
        $pdo = PDOProvider::get();
        $stmt = $pdo->prepare('SELECT * FROM `' . self::$table . '` WHERE room = :room');
        $stmt->execute([':room' => $room_id]);

        return array_map([__CLASS__, 'instance_from_data'], $stmt->fetchAll());
    }

    public static function exists(int $employee_id) : bool {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE employee_id = :employee_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':employee_id' => $employee_id]);

        return count($stmt->fetchAll()) > 0;
    }

    public static function get(int $employee_id) : ?Employees {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE employee_id = :employee_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':employee_id' => $employee_id]);
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

    public static function create(Employees $employee): Employees {
        $pdo = PDOProvider::get();

        $query = 'INSERT INTO `' . self::$table . '` (name, surname, job, wage, room) VALUES (:name, :surname, :job, :wage, :room)';

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $employee->name,
            'surname' => $employee->surname,
            'job' => $employee->job,
            'wage' => $employee->wage,
            'room' => $employee->room,
        ]);

        return self::get($pdo->lastInsertId());
    }

    public static function update(Employees $employee) {
        $pdo = PDOProvider::get();

        $query = 'UPDATE `' . self::$table . '` SET name = :name, surname = :surname, job = :job, wage = :wage, room = :room WHERE employee_id = :employee_id';

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'employee_id' => $employee->employee_id,
            'name' => $employee->name,
            'surname' => $employee->surname,
            'job' => $employee->job,
            'wage' => $employee->wage,
            'room' => $employee->room,
        ]);
    }

    public static function delete(int $employee_id) {
        $query = 'DELETE FROM `' . self::$table . '` WHERE employee_id = :employee_id';

        $pdo = PDOProvider::get();

        $stmt = $pdo->prepare($query);
        $stmt->execute(['employee_id' => $employee_id]);
    }

    private static function instance_from_data(array $data) : Employees {
        $employee = new Employees();
        $employee->employee_id = $data['employee_id'];
        $employee->name = $data['name'];
        $employee->surname = $data['surname'];
        $employee->job = $data['job'];
        $employee->wage = $data['wage'];
        $employee->room = $data['room'];
        return $employee;
    }
}
