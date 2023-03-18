<?php

use Core\Providers\PDOProvider;

class Employee {
    private static string $table = 'employee';

    public int $employee_id;
    public ?string $name;
    public ?string $surname;
    public ?string $job;
    public ?string $wage;
    public ?string $room;

    public function get_room() : Room {
        return Room::get($this->room);
    }

    public static function get($employee_id) : ?Employee {
        $pdo = PDOProvider::get();

        $query = 'SELECT * FROM `' . self::$table . '` WHERE employee_id = :employee_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute([':employee_id' => $employee_id]);
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

    private static function instance_from_data($data) : Employee {
        $employee = new Employee();
        $employee->employee_id = $data['employee_id'];
        $employee->name = $data['name'];
        $employee->surname = $data['surname'];
        $employee->job = $data['job'];
        $employee->wage = $data['wage'];
        $employee->room = $data['room'];
        return $employee;
    }
}
