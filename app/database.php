<?php

use Illuminate\Database\Capsule\Manager;

$capsule = new Manager();

$capsule->addConnection([
    'driver'    => 'sqlite',
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USERNAME'],
    'password'  => $_ENV['DB_PASSWORD'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);