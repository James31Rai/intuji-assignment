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
$router->addRoute('/event/add', CalendarEventController::class, 'addEvent');

$router->addRoute('/event/list', CalendarEventController::class, 'listEvent');

$router->addRoute('/event/delete', CalendarEventController::class, 'deleteEvent');

$router->addRoute('/disconnect', CalendarEventController::class, 'disconnectGoogle');