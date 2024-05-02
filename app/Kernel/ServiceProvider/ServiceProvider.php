<?php

namespace Sole\LiteWeb\Kernel\ServiceProvider;

use DI\Container;
use Psr\Container\ContainerInterface;

class ServiceProvider
{
    public function __construct(protected ContainerInterface|Container $container)
    {
    }

    public function register()
    {
    }

    public function boot()
    {
    }
}