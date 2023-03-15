<?php

require_once "../../bootstrap.php";

use Core\Pages\ErrorPage;
use Core\Exceptions\NotFoundException;

$page = new ErrorPage(new NotFoundException());
$page->render();
