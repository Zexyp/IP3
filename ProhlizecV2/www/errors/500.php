<?php

require_once "../../bootstrap.php";

use Browse\Pages\ErrorPage;
use Browse\Exceptions\InternalServerErrorException;

$page = new ErrorPage(new InternalServerErrorException());
$page->render();
