<?php

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Noodlehaus\Parser\Php;
use Sole\LiteWeb\Exception\ExceptionHandler;
use Sole\LiteWeb\Kernel\ApplicationContainer;
use Sole\LiteWeb\Kernel\ServiceProvider\ConfigServiceProvider;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

define('SLIM_START', microtime(true));
define('APP_BASE_PATH', rtrim(dirname(__DIR__), '/'));

$whoops = new Run;
$whoops->prependHandler(new ExceptionHandler());
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$container = (new ContainerBuilder(ApplicationContainer::class))
    ->addDefinitions(APP_BASE_PATH . '/config/definitions.php')
    ->useAttributes(true)
    ->build();

$app = Bridge::create($container);

$configProvider = $container->get(ConfigServiceProvider::class);
$configProvider->load();

require APP_BASE_PATH . '/routes/web.php';

return $app;