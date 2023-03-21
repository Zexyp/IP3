<?php
$config = parse_ini_file('config/config.ini');

$DB_HOST = $config['DB_HOST'];
$DB_PORT = $config['DB_PORT'];
$DB_DATABASE = $config['DB_DATABASE'];
$DB_USERNAME = $config['DB_USERNAME'];
$DB_PASSWORD = $config['DB_PASSWORD'];
$DB_CHARSET = $config['DB_CHARSET'];

$dsn = "mysql:host=$DB_HOST;dbname=$DB_DATABASE;charset=$DB_CHARSET;port=$DB_PORT";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, $DB_USERNAME, $DB_PASSWORD, $options);

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
    global $pdo, $DB_DATABASE;
    $query = "select concat(employee.name, ' ', employee.surname) as 'fullname', employee.employee_id from employee join $DB_DATABASE.key on employee.employee_id = $DB_DATABASE.key.employee where $DB_DATABASE.key.room = $id;";
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
    global $pdo, $DB_DATABASE;
    $query = "select room.name, room.no, room.room_id from room join $DB_DATABASE.key on room.room_id = $DB_DATABASE.key.room where $DB_DATABASE.key.employee = $id";
    return $pdo->query($query)->fetchAll(PDO::FETCH_OBJ);
}
