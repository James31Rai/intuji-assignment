<?php

use App\Controllers\HomeController;
use Core\Router;

$router = new Router();

/**
 * Add Custom routes
 */
$router->addRoute('/', HomeController::class, 'index');
$router->addRoute('/test', HomeController::class, 'test');