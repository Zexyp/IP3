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

function db_get_room($id)
{
    global $pdo;
    $query = "select room.name, room.no, room.phone from room where room.room_id = $id;";
    return $pdo->query($query)->fetch(PDO::FETCH_OBJ);
}