<?php

require __DIR__ . '/vendor/autoload.php';

use App\Utils\View;

define('URL', 'http://localhost/contatos-php');

View::init(['URL' => URL]);
