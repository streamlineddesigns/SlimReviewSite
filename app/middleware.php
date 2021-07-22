<?php
declare(strict_types=1);

use Slim\App;

return function (App $app) {
    $settings = $app->getContainer()->get('settings');

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Routing Middleware
    //$app->addRoutingMiddleware();

    // Handle errors
    $app->addErrorMiddleware($settings['displayErrorDetails'], $settings['logErrorDetails'], $settings['logErrors']);
};