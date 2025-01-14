<?php

require_once '../app/bootstrap.php';

use Slim\Factory\AppFactory;
use Dotenv\Dotenv;
use Whoops\Handler\PrettyPageHandler;

session_start();

$whoops = new \Whoops\Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

require_once '../app/database.php';

$capsule->setAsGlobal();
$capsule->bootEloquent();

require_once '../app/routes.php';

$app->run();

unset($app, $capsule, $dotenv, $whoops);