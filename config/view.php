<?php

return [
    'engine' => env('TEMPLATE_ENGINE', 'php'),
    'dir' => app_base_path('/resources/views'),
    'extension' => '.html',
    'render' => [
        'twig' => [
            'extension' => '.twig',
            'dir' => null,
            'options' => [
                'cache' => false,
            ],
        ],
        'php' => [
            'extension' => '.phtml',
            'dir' => null,
            'layout' => null,
        ],
    ],
];