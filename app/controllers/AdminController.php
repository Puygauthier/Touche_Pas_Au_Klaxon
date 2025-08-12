<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Database;

final class AdminController extends Controller
{
    public function dashboard(): void
    {
        if (!Auth::isAdmin()) {
            http_response_code(403);
            echo 'Accès refusé.';
            return;
        }

        $pdo = Database::getConnection();
        $counts = [
            'users'   => (int)$pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn(),
            'agences' => (int)$pdo->query("SELECT COUNT(*) FROM agences")->fetchColumn(),
            'trajets' => (int)$pdo->query("SELECT COUNT(*) FROM trajets")->fetchColumn(),
        ];

        $this->render('admin/dashboard', [
            'title'  => 'Tableau de bord administrateur',
            'counts' => $counts,
        ]);
    }
}
