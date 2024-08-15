<?php 

define('APP_NAME', $_ENV['APP_NAME']);
define('BASE_URL', $_ENV['APP_URL']);
define('APP_TIMEZONE', $_ENV['APP_TIMEZONE']);

$current_uri = ($_SERVER['HTTP_HOST']=='localhost' && str_contains(BASE_URL, $_SERVER['REQUEST_URI']))?'/':$_SERVER['REQUEST_URI'];
define('CURRENT_URI', $current_uri);