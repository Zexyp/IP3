<?php

require_once "../bootstrap.php";

use Core\Pages\AuthenticatedPage;

class IndexPage extends AuthenticatedPage
{
    protected function html_main(): string
    {
        return '<h1 class="display-1">Index</h1>';
    }
}

$page = new IndexPage();
$page->render();
