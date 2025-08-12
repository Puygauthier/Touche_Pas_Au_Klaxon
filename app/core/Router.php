<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    protected array $routes = ['GET' => [], 'POST' => []];

    public function get(string $path, $action): void  { $this->add('GET',  $path, $action); }
    public function post(string $path, $action): void { $this->add('POST', $path, $action); }

    protected function add(string $method, string $path, $action): void
    {
        $path  = '/' . ltrim($path, '/');
        // accepte aussi le "/" final
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $path);
        $regex = '#^' . $regex . '/?$#';
        $this->routes[$method][] = ['path' => $path, 'action' => $action, 'regex' => $regex];
    }

    public function dispatch(array $server): void
    {
        $method = $server['REQUEST_METHOD'] ?? 'GET';
        $uri    = $server['REQUEST_URI']   ?? '/';

        // 1) retire la query string
        if (false !== ($q = strpos($uri, '?'))) {
            $uri = substr($uri, 0, $q);
        }

        // 2) calcule le préfixe réel jusqu'à /public via SCRIPT_NAME
        //    ex: /Touche_Pas_Au_Klaxon/public/index.php -> /Touche_Pas_Au_Klaxon/public
        $script = str_replace('\\','/', $server['SCRIPT_NAME'] ?? '');
        $base   = rtrim(dirname($script), '/');

        // 3) enlève le préfixe détecté (avec ou sans slash final)
        if ($base !== '' && strpos($uri, $base) === 0) {
            $uri = substr($uri, strlen($base));
        }
        if ($uri === '' || $uri === false) { $uri = '/'; }

        // 4) normalise
        if ($uri[0] !== '/') { $uri = '/' . $uri; }
        if ($uri === '/index.php') { $uri = '/'; }

        // 5) match
        foreach ($this->routes[$method] ?? [] as $route) {
            if (preg_match($route['regex'], $uri, $m)) {
                $params = array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->invoke($route['action'], $params);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Route '{$uri}' non définie";
    }

    protected function invoke($action, array $params): void
    {
        if (is_callable($action)) {
            call_user_func_array($action, $params);
            return;
        }
        if (is_string($action)) {
            [$controller, $method] = explode('@', $action);
            $controllerClass = 'App\\Controllers\\' . $controller;

            if (!class_exists($controllerClass)) {
                throw new \RuntimeException("Contrôleur {$controllerClass} introuvable.");
            }
            $instance = new $controllerClass();
            if (!method_exists($instance, $method)) {
                throw new \RuntimeException("Méthode {$method} introuvable dans {$controllerClass}.");
            }
            call_user_func_array([$instance, $method], $params);
            return;
        }
        throw new \InvalidArgumentException('Action de route invalide');
    }
}
