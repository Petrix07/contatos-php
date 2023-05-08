<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Http\Router,
    \App\Utils\View,
    \WilliamCosta\DotEnv\Environment;


Environment::load(__DIR__);

define('URL', getenv('URL'));

View::init(['URL' => URL]);

$obRouter = new Router(URL);

include __DIR__ . '/routes/pages.php';

$obRouter->run()
    ->sendResponse();
