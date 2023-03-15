<?php

require_once "../../bootstrap.php";

use Core\Pages\ErrorPage;
use Core\Exceptions\InternalServerErrorException;

$page = new ErrorPage(new InternalServerErrorException());
$page->render();
