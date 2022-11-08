<?php
include 'database.inc';
include 'utils.inc';
$employee_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$employee = db_get_employee($employee_id);
?>
<!doctype html>
<html lang="en">
<?php echo_header($employee->fullname); ?>
<body>
<div class="container">
    <ol class="breadcrumbs">
        <li class="breadcrumbs-item"><a href="index.php">Prohlížeč</a></li>
        <li class="breadcrumbs-item"><a href="employees_list.php">Zaměstnanci</a></li>
    </ol>
    <h1 class="align-middle"><?php echo $employee->fullname; ?></h1>

    <dl class="dl-horizontal">
        <dt>Jméno</dt>
        <dd><?php echo $employee->name; ?></dd>
        <dt>Příjmení</dt>
        <dd><?php echo $employee->surname; ?></dd>
        <dt>Pozice</dt>
        <dd><?php echo $employee->job; ?></dd>
        <dt>Mzda</dt>
        <dd><?php echo $employee->wage; ?></dd>
        <dt>Místnost</dt>
        <dd><a href='room.php?id=<?php echo $employee->room_id; ?>'><?php echo "$employee->room_name (č. $employee->room_no)"; ?></a></dd>
        <dt>Klíče</dt>
<?php
$keys = db_get_employee_keys($employee_id);
foreach ($keys as $key) {
    echo "<dd><a href='room.php?id=$key->room_id'>$key->name (č. $key->no)</a></dd>";
}
?>
    </dl>
</div>
</body>
</html>