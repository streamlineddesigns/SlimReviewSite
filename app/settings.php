<?php
declare(strict_types=1);

use DI\Container;

return function (Container $container) {
    $container->set('settings', function () {
        return [
            'Name' => 'Color Switch Reviews',
            'displayErrorDetails' => true,
            'logErrorDetails' => true,
            'logErrors' => true,

            'db' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'homestead',
                'username' => 'homestead',
                'password' => 'secret',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ],

            'views' => [
                'path' => __DIR__ . '/../src/Views',
                'settings' => ['cache' => false, 'debug' => true],
            ],
        ];
    });
};