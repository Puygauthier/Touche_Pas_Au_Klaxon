<?php
session_start();

// Définir le chemin de base
define('ROOT', dirname(__DIR__));

// Autoloader des classes
require_once ROOT . '/app/core/Autoloader.php';
App\Core\Autoloader::register();

// Lancer le routeur
use App\Core\Router;

$router = new Router();
$router->handleRequest();
