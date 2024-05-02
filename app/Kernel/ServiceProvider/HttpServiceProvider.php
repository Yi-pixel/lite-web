<?php

namespace Sole\LiteWeb\Kernel\ServiceProvider;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\RequestFactory;
use Slim\Psr7\Factory\ResponseFactory;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use function DI\create;

class HttpServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->container->set(ResponseFactoryInterface::class, create(ResponseFactory::class));
        $this->container->set(ResponseInterface::class, create(Response::class));
        $this->container->set(RequestFactoryInterface::class, create(RequestFactory::class));
        $this->container->set(RequestInterface::class, create(Request::class));
    }

}