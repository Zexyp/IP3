<?php
include 'database.inc';
include 'utils.inc';
?>
<!doctype html>
<html lang="en">
<?php echo_header("Místnosti"); ?>
<body>
<div class="container">
    <ol class="breadcrumbs">
        <li class="breadcrumbs-item"><a href="index.php">Prohlížeč</a></li>
    </ol>
    <h1 class="align-middle">Místnosti</h1>

    <table class="table">
        <thead>
            <tr>
<?php
echo_sortable_header_column('Název', 'name');
echo_sortable_header_column('Číslo', 'no');
echo_sortable_header_column('Telefon', 'phone');
?>
            </tr>
        </thead>
        <tbody>
<?php
$orderName = null;
$orderOrder = null;
if (isset($_GET['order'])) {
    $params = explode('_', $_GET['order']);
    if (in_array($params[0], ['name', 'no', 'phone']))
        $orderName = $params[0];
    switch ($params[1])
    {
        case 'up': $orderOrder = 'asc'; break;
        case 'down': $orderOrder = 'desc'; break;
    }
}

$rooms = db_get_rooms_list($orderName, $orderOrder);
foreach ($rooms as $room) {
    echo "
<tr>
    <td><a href='room.php?id={$room->room_id}'>{$room->name}</a></td>
    <td>{$room->no}</td>
    <td>{$room->phone}</td>
</tr>";
}
?>
        </tbody>
    </table>
</div>
</body>
</html>