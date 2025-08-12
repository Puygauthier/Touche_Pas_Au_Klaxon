<?php
namespace App\Core;

abstract class Controller
{
    /** Rendu d’une vue enveloppée par le layout */
    protected function render(string $view, array $params = []): void
    {
        // Expose les variables pour la vue (ex: $title, $users, etc.)
        extract($params, EXTR_SKIP);

        // 1) Vue -> $content
        $viewFile = \dirname(__DIR__, 1) . '/views/' . ltrim($view, '/')
                  . (str_ends_with($view, '.php') ? '' : '.php');

        if (!is_file($viewFile)) {
            http_response_code(500);
            echo "Vue '{$view}' introuvable.";
            return;
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // 2) Layout
        $layoutFile = \dirname(__DIR__, 1) . '/views/layout.php';
        if (is_file($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    /** Redirection utilitaire */
    protected function redirect(string $path): void
    {
        $base = \defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
        header('Location: ' . $base . $path);
        exit;
    }
}
