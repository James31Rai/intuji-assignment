<?php

// Registering PSR-4 Autoloader
spl_autoload_register( 'psr4_autoloader' );

/**
 * PSR-4 Autoloader.
 *
 * @param string $class
 * @return void
 */
function psr4_autoloader($class) 
{
    $class_path = str_replace('\\', '/', $class);
    
    $file =  __DIR__ . '/' . $class_path . '.php';

    if (file_exists($file)) {
        require $file;
    }
}