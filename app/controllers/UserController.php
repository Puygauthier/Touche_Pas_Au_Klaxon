<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        $userModel = new User();
        $users = $userModel->findAll();

        $this->render('user/index', [
            'title' => 'Liste des utilisateurs',
            'users' => $users,
        ]);
    }

    public function show($id): void
    {
        $id = (int)$id;
        if ($id <= 0) {
            http_response_code(400);
            echo 'Requête invalide.';
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($id);

        if (!$user) {
            http_response_code(404);
            echo 'Utilisateur non trouvé.';
            return;
        }

        $this->render('user/show', [
            'title' => 'Détail utilisateur',
            'user'  => $user,
        ]);
    }
}
