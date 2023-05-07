<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/routes.php';

use App\Controller\Pages\Home;

echo Home::getHome();
