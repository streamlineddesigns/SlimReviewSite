<?php
declare(strict_types=1);

use DI\Container;
use Twig\Loader\FilesystemLoader;
use Slim\Views\Twig;
use App\Twig\CustomTwigExtensions;
use Twig\Extra\Intl\IntlExtension;
use Twig\Extension\DebugExtension;

return function (Container $container) {
    $container->set('view', function ($container) {

        $ViewSettings = $container->get('settings')['views'];
        $loader = new FilesystemLoader($ViewSettings['path']);
        $twig = new Twig($loader, $ViewSettings['settings']);

        $twig->addExtension(new CustomTwigExtensions($container));
        $twig->addExtension(new IntlExtension());

        if ($ViewSettings['settings']['debug']) {
            $twig->addExtension(new DebugExtension());
        }
        return $twig;

    });
};