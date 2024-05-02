<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory\RequestFactory;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\PhpRenderer;
use Slim\Views\Twig;
use function DI\create;
use function DI\factory;
use function DI\get;

return [
    ResponseFactoryInterface::class => create(ResponseFactory::class),
    ResponseInterface::class => create(Response::class),
    RequestFactoryInterface::class => create(RequestFactory::class),
    RequestInterface::class => create(Request::class),
    'logger.writer' => factory(function () {
        $log = new Logger('application');
        $log->pushHandler(new StreamHandler(storage_path('/logs/' . date('Y-m-d') . '.log')));

        return $log;
    }),
    LoggerInterface::class => get('logger.writer'),
    Logger::class => get('logger.writer'),
];