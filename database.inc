<?php
$config = parse_ini_file('config.ini');
$DB_HOST = $config['DB_HOST'];
$DB_DB = $config['DB_DB'];
$DB_USER = $config['DB_USER'];
$DB_PASS = $config['DB_PASS'];

$charset = 'utf8mb4';

$dsn = "mysql:host=$DB_HOST;dbname=$DB_DB;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);

function db_get_rooms_list($orderColumn = null, $orderOrder = null) {
    global $pdo;
    $order = ($orderColumn !== null && $orderOrder !== null) ? "order by $orderColumn $orderOrder" : '';
    $query = "select room.room_id, room.name, room.no, room.phone from room $order;";
    return $pdo->query($query)->fetchAll(PDO::FETCH_OBJ);
}

function db_get_room($id) {
    global $pdo;
    $query = "select room.name, room.no, room.phone from room where room.room_id = $id;";
    return $pdo->query($query)->fetch(PDO::FETCH_OBJ);
}

function db_get_room_employees($id) {
    global $pdo;
    $query = "select concat(employee.name, ' ', employee.surname) as 'fullname', employee.employee_id from employee where employee.room = $id;";
    return $pdo->query($query)->fetchAll(PDO::FETCH_OBJ);
}

function db_get_room_keys($id) {
    global $pdo, $DB_DB;
    $query = "select concat(employee.name, ' ', employee.surname) as 'fullname', employee.employee_id from employee join $DB_DB.key on employee.employee_id = ip_3.key.employee where $DB_DB.key.room = $id;";
    return $pdo->query($query)->fetchAll(PDO::FETCH_OBJ);
}

function db_get_room_average_wage($id) {
    global $pdo;
    $query = "select avg(employee.wage) as 'avg' from employee where employee.room = $id;";
    return $pdo->query($query)->fetch(PDO::FETCH_OBJ)->avg;
}

function db_get_employees_list($orderColumn = null, $orderOrder = null) {
    global $pdo;
    $order = ($orderColumn !== null && $orderOrder !== null) ? "order by $orderColumn $orderOrder" : '';
    $query = "select employee.employee_id, concat(employee.name, ' ', employee.surname) as 'fullname', room.no, room.phone, employee.job from employee join room on employee.room = room.room_id  $order;";
    return $pdo->query($query)->fetchAll(PDO::FETCH_OBJ);
}

function db_get_employee($id) {
    global $pdo;
    $query = "select concat(employee.name, ' ', employee.surname) as 'fullname', employee.name, employee.surname, employee.wage, room.room_id, room.name as 'room_name', room.no as 'room_no', employee.job from employee join room on employee.room = room.room_id where employee.employee_id = $id;";
    return $pdo->query($query)->fetch(PDO::FETCH_OBJ);
}

function db_get_employee_keys($id) {
    global $pdo, $DB_DB;
    $query = "select room.name, room.no, room.room_id from room join $DB_DB.key on room.room_id = $DB_DB.key.room where $DB_DB.key.employee = $id";
    return $pdo->query($query)->fetchAll(PDO::FETCH_OBJ);
}
