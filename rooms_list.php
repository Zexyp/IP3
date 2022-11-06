<?php
include 'database.inc';
include 'utils.inc';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Místnosti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="base.css" rel="stylesheet"/>
</head>
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
sortable_header_column('Název', 'name');
sortable_header_column('Číslo', 'no');
sortable_header_column('Telefon', 'phone');
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
for ($i = 0; $i < count($rooms); $i++) {
    echo "
<tr>
    <td><a href='room.php?id={$rooms[$i]->room_id}'>{$rooms[$i]->name}</a></td>
    <td>{$rooms[$i]->no}</td>
    <td>{$rooms[$i]->phone}</td>
</tr>";
}
?>
        </tbody>
    </table>
</div>
</body>
</html>