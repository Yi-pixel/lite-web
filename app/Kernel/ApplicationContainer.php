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
    private bool $booted = false;

    public function __construct(MutableDefinitionSource|array $definitions = [], ProxyFactory $proxyFactory = null, ContainerInterface $wrapperContainer = null)
    {
        parent::__construct($definitions, $proxyFactory, $wrapperContainer);


        self::$instance = $this;
    }

    public function bootstrap(): void
    {
        if ($this->booted) {
            return;
        }

        $this->initializeServiceProviders();

        $this->registerServiceProvider();

        $this->bootServiceProvider();

        $this->booted = true;
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function registerServiceProvider(): void
    {
        foreach (self::$providers as $provider) {
            $this->call([$provider, 'register']);
        }
    }

    public function initializeServiceProviders(): array
    {
        $providers = require APP_BASE_PATH . '/bootstrap/providers.php';
        foreach ($providers as $provider) {
            self::$providers[$provider] ??= new $provider($this);
        }

        return self::$providers;
    }

    public function bootServiceProvider(): void
    {
        foreach (self::$providers as $provider) {
            $this->call([$provider, 'boot']);
        }
    }
}