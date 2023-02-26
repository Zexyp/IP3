<?php
include 'database.inc';
include 'utils.inc';
$room_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$room = db_get_room($room_id);
?>
<!doctype html>
<html lang="en">
<?php echo_header("$room->name (č. $room->no)"); ?>
<body>
<div class="container">
    <ol class="breadcrumbs">
        <li class="breadcrumbs-item"><a href="index.php">Prohlížeč</a></li>
        <li class="breadcrumbs-item"><a href="rooms_list.php">Místnosti</a></li>
    </ol>
    <h1 class="align-middle"><?php echo "$room->name (č. $room->no)"; ?></h1>

    <dl class="dl-horizontal">
        <dt>Číslo</dt>
        <dd><?php echo $room->no; ?></dd>
        <dt>Název</dt>
        <dd><?php echo $room->name; ?></dd>
        <dt>Telefon</dt>
        <dd><?php echo $room->phone; ?></dd>
        <dt>Lidé</dt>
<?php
$employees = db_get_room_employees($room_id);
foreach ($employees as $employee) {
    echo "<dd><a href='employee.php?id=$employee->employee_id'>$employee->fullname</a></dd>";
}
?>
        <dt>Průměrná mzda</dt>
        <dd><?php echo db_get_room_average_wage($room_id); ?></dd>
        <dt>Klíče</dt>
<?php
$keys = db_get_room_keys($room_id);
foreach ($keys as $key) {
    echo "<dd><a href='employee.php?id=$key->employee_id'>$key->fullname</a></dd>";
}
?>
    </dl>
</div>
</body>
</html>