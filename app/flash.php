<?php
declare(strict_types=1);

use DI\Container;
use Slim\Flash\Messages;

return function (Container $container) {
    $container->set('flash', function ($container) {
        return new Messages();
    });
};