<?php

use Sole\LiteWeb\Controller\IndexController;

$app = \app();
$app->get('/', [IndexController::class, 'index']);
