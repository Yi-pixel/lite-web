<?php

namespace Sole\LiteWeb\Kernel\ServiceProvider;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use function DI\factory;
use function DI\get;

class LoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $container = container();
        $container->set('logger.writer', factory(function () {
            $log = new Logger('application');
            $log->pushHandler(new StreamHandler(storage_path('/logs/' . date('Y-m-d') . '.log')));

            return $log;
        }));

        $container->set(LoggerInterface::class, get('logger.writer'));
        $container->set(Logger::class, get('logger.writer'));
    }

}