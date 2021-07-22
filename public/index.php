<?php
declare(strict_types=1);

use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

require __DIR__ . '/../vendor/autoload.php';

//start a session for success/failure messages
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Create Container using PHP-DI
$container = new Container();

// Setup Settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($container);

// Setup flash.. Views depend on flash, so flash needs to be setup first!
$flash = require __DIR__ . '/../app/flash.php';
$flash($container);

// Views
$views = require __DIR__ . '/../app/views.php';
$views($container);

// Instantiate the app
$app = SlimAppFactory::create($container);

// Set up database
$database = require __DIR__ . '/../app/database.php';
$database($container);
$app->getContainer()->get('db');

// Middleware
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

// Run the app
$app->run();