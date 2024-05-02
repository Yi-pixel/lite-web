<?php
declare(strict_types=1);

use Sole\LiteWeb\Kernel\ServiceProvider\AppServiceProvider;
use Sole\LiteWeb\Kernel\ServiceProvider\ConfigServiceProvider;
use Sole\LiteWeb\Kernel\ServiceProvider\HttpServiceProvider;
use Sole\LiteWeb\Kernel\ServiceProvider\LoggerServiceProvider;
use Sole\LiteWeb\Kernel\ServiceProvider\ViewServiceProvider;

return [
    ConfigServiceProvider::class,
    HttpServiceProvider::class,
    LoggerServiceProvider::class,
    ViewServiceProvider::class,
    AppServiceProvider::class,
];