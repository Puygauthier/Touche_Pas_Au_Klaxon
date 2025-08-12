<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(): void
    {
        // déjà connecté ? -> accueil
        if (Auth::isLoggedIn()) {
            $this->redirect('/');
        }

        // GET : afficher le formulaire
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->render('auth/login', [
                'title' => 'Connexion',
                'error' => null,
                'old'   => ['email' => ''],
            ]);
            return;
        }

        // POST : traiter la soumission
        $email = trim($_POST['email'] ?? '');
        $pass  = (string)($_POST['password'] ?? '');
        $error = null;

        if ($email === '' || $pass === '') {
            $error = 'Veuillez remplir tous les champs.';
        } else {
            $user = (new User())->findByEmail($email); // doit renvoyer mot_de_passe (hash)
            if (!$user || empty($user['mot_de_passe']) || !password_verify($pass, $user['mot_de_passe'])) {
                $error = 'Email ou mot de passe incorrect.';
            }
        }

        if ($error) {
            $this->render('auth/login', [
                'title' => 'Connexion',
                'error' => $error,
                'old'   => ['email' => $email],
            ]);
            return;
        }

        // Connexion OK -> stocke juste ce dont le layout a besoin
        Auth::login([
            'id'     => (int)$user['id'],
            'prenom' => (string)($user['prenom'] ?? ''),
            'nom'    => (string)($user['nom'] ?? ''),
            'role'   => (string)($user['role'] ?? 'utilisateur'),
            'email'  => (string)($user['email'] ?? ''),
        ]);

        $this->redirect('/');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/');
    }
}
