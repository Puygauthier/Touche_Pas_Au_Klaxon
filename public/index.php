<?php
declare(strict_types=1);

// Sessions
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Chemins
define('ROOT', dirname(__DIR__));

// Base des URLs : '' avec le serveur PHP intégré (et VirtualHost)
define('BASE_PATH', '');

// Forcer UTF-8 côté sortie
header('Content-Type: text/html; charset=UTF-8');

// Autoloader
require_once ROOT . '/app/core/Autoloader.php';
App\Core\Autoloader::register();

use App\Core\Router;

// Routeur
$router = new Router(BASE_PATH);

// Déclaration des routes
require_once ROOT . '/app/routes.php';

// Dispatch
$router->dispatch($_SERVER);
