<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use DI\Container;
use Twig\TwigFunction;

class CustomTwigExtensions extends AbstractExtension
{
    public $container;
    public $messages;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->messages = $this->container->get('flash')->getMessages();
    }
    
    public function getFunctions()
    {
        return [
            new TwigFunction('url', [$this, 'url']),
            new TwigFunction('hasMessages', [$this, 'hasMessages']),
            new TwigFunction('successMessage', [$this, 'successMessage']),
            new TwigFunction('errorMessage', [$this, 'errorMessage']),
            new TwigFunction('inArray', [$this, 'inArray']),
        ];
    }

    public function url($asset_url)
    {
        $url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $asset_url;
        $url = strtok($url, "?");
        return $url;
    }

    public function hasMessages()
    {
        if (isset($this->messages)) {
            return true;
        } else {
            return false;
        }
    }

    public function successMessage()
    {
        if (isset($this->messages["success"])) {
            return $this->messages["success"][0];
        } else {
            return false;
        }
    }

    public function errorMessage()
    {
        if (isset($this->messages["error"])) {
            return $this->messages["error"][0];
        } else {
            return false;
        }
    }

    public function inArray($needle, $haystack)
    {
        if (in_array($needle, $haystack)) {
            return true;
        } else {
            return false;
        }
    }
}