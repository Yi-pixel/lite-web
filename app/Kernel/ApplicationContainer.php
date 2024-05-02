<?php

namespace Sole\LiteWeb\Kernel;

use DI\Container;
use DI\Definition\Source\MutableDefinitionSource;
use DI\Proxy\ProxyFactory;
use Psr\Container\ContainerInterface;

class ApplicationContainer extends Container
{
    private static self $instance;
    private static array $providers = [];

    public function __construct(MutableDefinitionSource|array $definitions = [], ProxyFactory $proxyFactory = null, ContainerInterface $wrapperContainer = null)
    {
        parent::__construct($definitions, $proxyFactory, $wrapperContainer);


        self::$instance = $this;
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    public static function registerServiceProvider(ContainerInterface $container): void
    {
        foreach (self::$providers as $provider) {
            $container->call([$provider, 'register']);
        }
    }

    public static function initializeServiceProviders(ContainerInterface $container)
    {
        $providers = require APP_BASE_PATH . '/boostrap/providers.php';
        foreach ($providers as $provider) {
            self::$providers[$provider] ??= new $provider($container);
        }

        return self::$providers;
    }

    public static function bootServiceProvier(ContainerInterface $container)
    {
        foreach (self::$providers as $provider) {
            $container->call([$provider, 'boot']);
        }
    }
}