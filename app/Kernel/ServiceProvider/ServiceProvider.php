<?php

namespace Sole\LiteWeb\Kernel\ServiceProvider;

use Psr\Container\ContainerInterface;

class ServiceProvider
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function register()
    {
    }

    public function boot()
    {
    }
}