<?php

use app\core\Application;

require_once __DIR__ . '/vendor/autoload.php';


$app = new Application();

$app->router->get('/', function () {
    return 'hello world';
});

$app->router->get('/contact', function () {
    return 'contact';
});


$app->run();