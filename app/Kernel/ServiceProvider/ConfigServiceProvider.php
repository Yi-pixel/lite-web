<?php

namespace Sole\LiteWeb\Kernel\ServiceProvider;

use Dflydev\DotAccessData\Data;
use Dotenv\Dotenv;

class ConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->load();
    }

    public function load()
    {
        $dotenv = Dotenv::createImmutable(APP_BASE_PATH);
        $dotenv->safeLoad();

        $files = $this->getFiles();
        $data = [];
        foreach ($files as $file) {
            $key = pathinfo($file, PATHINFO_FILENAME);
            $data[$key] = require $file;
        }

        $this->container->set('config', new Data($data));
    }

    private function getFiles(): array
    {
        return glob(APP_BASE_PATH . '/config/*.php');
    }
}