<?php
declare(strict_types=1);

use DI\Container;

return function (Container $container) {
    $container->set('db', function ($container) {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($container->get('settings')['db']);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    });
};