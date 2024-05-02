<?php

namespace PHPSTORM_META {

    use Dflydev\DotAccessData\Data;

    override(\Psr\Container\ContainerInterface::get(0), $containerMappings = map([
        '' => '@',
        'config' => Data::class,
    ]));
    override(\DI\Container::get(0), $containerMappings);
    override(\app(0), $containerMappings);
    override(\container(0), $containerMappings);
    override(\resolve(0), $containerMappings);
}