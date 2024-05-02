<?php

namespace Sole\LiteWeb\Kernel;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;
use Slim\Views\Twig;

class ResponseFactory
{
    private ResponseInterface|null $response = null;

    public function __construct(ResponseInterface $response = null)
    {
        $this->response = $response ?? app(ResponseInterface::class);
    }

    public function withContent($content): self
    {
        if ($content === null) {
            return $this;
        }

        if ($content instanceof ResponseInterface) {
            $this->response = $content;
        }

        if (is_object($content) && method_exists($content, 'toResponse')) {
            $content = $content->toResponse();
        }

        if (is_array($content) || is_object($content) || $content instanceof \JsonSerializable) {
            $content = json_encode($content);
            $this->response = $this->response->withHeader('Content-Type', 'application/json');
        }

        $this->response->getBody()->write($content);

        return $this;
    }

    public function send()
    {
        return $this->response;
    }

    public function view(string $template, array $data = [], string|bool $useLayout = true)
    {
        $template = $this->completePath($template);

        /** @var PhpRenderer|Twig $view */
        $view = container('view');
        if (is_string($useLayout)) {
            $view = clone $view;
            $view->setLayout($useLayout);

            $useLayout = true;
        }

        return $this->withContent($view->fetch($template, $data, $useLayout));
    }

    /**
     * @param string $template
     * @return string
     */
    private function completePath(string $template): string
    {
        if (!str_starts_with($template, '/')) {
            $template = '/pages/' . $template;
        }

        if (($ext = config('view.render.' . config('view.engine') . '.extension', config('view.extension'))) && !str_ends_with($template, $ext)) {
            $template .= $ext;
        }

        return $template;
    }
}