<?php

use Core\DotEnv;
use Core\Session;

// custom autoload
include 'autoload.php';
// composer autoload
include 'vendor/autoload.php';

$__DotEnv = new DotEnv(realpath(__DIR__."\.env"));

$session = new Session();

include 'core/Config.php';

include 'core/Helper.php';

include 'app/routes.php';

$router->dispatch(CURRENT_URI);