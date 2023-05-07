<?php

require __DIR__ . '/vendor/autoload.php';

use App\Http\Router,
    App\Utils\View;

define('URL', 'http://localhost/contatos-php');

View::init(['URL' => URL]);

$obRouter = new Router(URL);

include __DIR__ . '/routes/pages.php';

$obRouter->run()
    ->sendResponse();
