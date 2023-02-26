<?php
include 'database.inc';
include 'utils.inc';
?>
<!doctype html>
<html lang="en">
<?php echo_header("Zaměstnanci"); ?>
<body>
<div class="container">
    <ol class="breadcrumbs">
        <li class="breadcrumbs-item"><a href="index.php">Prohlížeč</a></li>
    </ol>
    <h1 class="align-middle">Zaměstnanci</h1>

    <table class="table">
        <thead>
            <tr>
<?php
echo_sortable_header_column('Jméno', 'fullname');
echo_sortable_header_column('Místnost', 'no');
echo_sortable_header_column('Telefon', 'phone');
echo_sortable_header_column('Pozice', 'job');
?>
            </tr>
        </thead>
        <tbody>
<?php
$orderName = null;
$orderOrder = null;
if (isset($_GET['order'])) {
    $params = explode('_', $_GET['order']);
    if (in_array($params[0], ['fullname', 'no', 'phone', 'job']))
        $orderName = $params[0];
    switch ($params[1])
    {
        case 'up': $orderOrder = 'asc'; break;
        case 'down': $orderOrder = 'desc'; break;
    }
}

$employees = db_get_employees_list($orderName, $orderOrder);
foreach ($employees as $employee) {
    echo "
<tr>
    <td><a href='employee.php?id={$employee->employee_id}'>{$employee->fullname}</a></td>
    <td>{$employee->no}</td>
    <td>{$employee->phone}</td>
    <td>{$employee->job}</td>
</tr>";
}
?>
        </tbody>
    </table>
</div>
</body>
</html>