<?php

namespace App\Http\Controllers;

use Psr\Container\ContainerInterface;

abstract class Controller
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        //apparently you need to call flash to get the messages to be available. What a headache trying to figure this out.
        $flash = $this->container->get('flash');
    }
}