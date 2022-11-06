<?php
include 'database.inc';
$room_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$room = db_get_room($room_id);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo "$room->name (č. $room->no)"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="base.css" rel="stylesheet"/>
</head>
<body>
<div class="container">
    <ol class="breadcrumbs">
        <li class="breadcrumbs-item"><a href="index.php">Prohlížeč</a></li>
        <li class="breadcrumbs-item"><a href="rooms_list.php">Místnosti</a></li>
    </ol>
    <h1 class="align-middle"><?php echo "$room->name (č. $room->no)"; ?></h1>

    <table class="table">
        <tbody>
        <tr>
            <td class="font-weight-bold">Název</td><td><?php echo $room->name; ?></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>