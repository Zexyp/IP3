<?php

require_once "../bootstrap.php";

use Core\Pages\AuthenticatedPage;

class IndexPage extends AuthenticatedPage
{
    protected string $title = "Index";

    protected function html_main(): string
    {
        return '<div class="m-2 p-2 glow-text"><h1 class="display-3 my-5">Index</h1></div>';
    }
}

$page = new IndexPage();
$page->render();
