<?php

namespace Sole\LiteWeb\Kernel\ServiceProvider;

use Psr\Container\ContainerInterface;
use Slim\Views\PhpRenderer;
use Slim\Views\Twig;
use function DI\factory;
use function DI\get;

class ViewServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->addTwig();

        $this->addPhp();

        $this->container->set('view', factory(function (ContainerInterface $container) {
            return $container->get('view.render.' . config('view.engine'));
        }));

    }

    /**
     * @return void
     */
    private function addTwig(): void
    {
        $this->container->set('view.render.twig', factory(function () {
            return Twig::create(config('view.render.twig.dir', config('view.dir')), config('view.render.twig.options'));
        }));

        $this->container->set(Twig::class, get('view.render.twig'));
    }

    /**
     * @return void
     */
    private function addPhp(): void
    {
        $this->container->set('view.render.php', factory(function () {
            return new PhpRenderer(config('view.render.php.dir', config('view.dir')), ['title' => 'Page'], config('view.render.php.layout', 'layout.phtml'));
        }));

        $this->container->set(PhpRenderer::class, get('view.render.php'));
    }
}