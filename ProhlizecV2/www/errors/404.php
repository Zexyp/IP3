<?php

require_once "../../bootstrap.php";

use Browse\Pages\ErrorPage;
use Browse\Exceptions\NotFoundException;

$page = new ErrorPage(new NotFoundException());
$page->render();
