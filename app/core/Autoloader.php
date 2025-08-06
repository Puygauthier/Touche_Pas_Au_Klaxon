<?php
namespace App\Core;

class Autoloader {
    public static function register() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class) {
        $class = str_replace('App\\', '', $class);
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $file = ROOT . '/app/' . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
}
