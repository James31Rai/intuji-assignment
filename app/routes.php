<?php

use App\Controllers\CalendarEventController;
use App\Controllers\HomeController;
use Core\Router;

$router = new Router();

/**
 * Add Custom routes
 */
$router->addRoute('/', HomeController::class, 'index');

$router->addRoute('/google_authorize', CalendarEventController::class, 'googleAuthorize');

$router->addRoute('/event', CalendarEventController::class, 'index');