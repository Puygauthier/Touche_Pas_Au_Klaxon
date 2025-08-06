<?php
namespace App\Core;

class Router {
    public function handleRequest() {
        $controllerName = $_GET['controller'] ?? 'home';
        $actionName = $_GET['action'] ?? 'index';

        $controllerClass = 'App\\Controllers\\' . ucfirst($controllerName) . 'Controller';

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                http_response_code(404);
                echo "Action '$actionName' non trouvée.";
            }
        } else {
            http_response_code(404);
            echo "Contrôleur '$controllerName' non trouvé.";
        }
    }
}
