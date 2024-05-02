<?php

use Dflydev\DotAccessData\Data;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Slim\App;
use Sole\LiteWeb\Kernel\ApplicationContainer;
use Sole\LiteWeb\Kernel\ResponseFactory;

if (!function_exists('app')) {
    /**
     * @template T
     * @psalm-param  class-string<T> $abstract
     * @return T|App
     * @psalm-return (T is null ? App : T)
     * @throws NotFoundException
     * @throws DependencyException
     */
    function app(string $abstract = null, array $parameters = [])
    {
        $container = ApplicationContainer::getInstance();

        if ($abstract === null) {
            return $container->get(App::class);
        }

        return $container->make($abstract, $parameters);
    }
}

if (!function_exists('container')) {
    /**
     * then get a parsed instance from the container
     *
     * @template T
     * @psalm-param  class-string<T> $abstract
     * @return T|Container
     * @psalm-return (T is null ? Container : T)
     * @throws NotFoundException
     * @throws DependencyException
     */
    function container(string $abstract = null)
    {
        $container = ApplicationContainer::getInstance();
        if ($abstract === null) {
            return $container;
        }

        return $container->get($abstract);
    }
}

if (!function_exists('resolve')) {
    /**
     * always resolve new instances from the container
     *
     * @template T
     * @psalm-param class-string<T> $abstract
     * @param array $parameters
     * @return T|Container
     * @psalm-return (T is null ? Container : T)
     * @throws DependencyException
     * @throws NotFoundException
     */
    function resolve(string $abstract, array $parameters = [])
    {
        return ApplicationContainer::getInstance()->make($abstract, $parameters);
    }
}

if (!function_exists('response')) {
    function response($data)
    {
        return resolve(ResponseFactory::class)
            ->withContent($data)
            ->send();
    }
}

if (!function_exists('view')) {
    function view(string $view, array $data = [], string|bool $useLayout = true)
    {
        return resolve(ResponseFactory::class)
            ->view($view, $data, $useLayout)
            ->send();
    }
}

if (!function_exists('e')) {
    function e($value, bool $doubleEncode = true): string
    {
        if ($value instanceof BackedEnum) {
            $value = $value->value;
        }

        return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', $doubleEncode);
    }
}

if (!function_exists('app_base_path')) {
    function app_base_path(string $path = ''): string
    {
        return APP_BASE_PATH . '/' . ltrim($path, '/');
    }
}

if (!function_exists('storage_path')) {
    function storage_path(string $path = ''): string
    {
        return APP_BASE_PATH . '/storage/' . ltrim($path, '/');
    }
}
if (!function_exists('logger')) {
    function logger(...$args): LoggerInterface
    {
        $loggerWriter = \container('logger.writer');
        if (count($args)) {
            /** @var Logger $loggerWriter */
            $loggerWriter->addRecord(...$args);
        }

        return $loggerWriter;
    }
}

if (!function_exists('value')) {
    function value($value, ...$args)
    {
        if ($value instanceof Closure) {
            return $value(...$args);
        }

        return $value;
    }
}

if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        if (array_key_exists($key, $_ENV ?? [])) {
            return $_ENV[$key];
        }

        return value($default);
    }
}

if (!function_exists('config')) {
    function config(string|array|null $key = null, $default = null)
    {
        /** @var Data $config */
        $config = \container('config');
        if ($key === null) {
            return $config;
        }

        if (is_string($key)) {
            return $config->get($key, value($default));
        }

        foreach ($key as $k => $v) {
            $config->set($k, $v);
        }

        return $config;
    }
}