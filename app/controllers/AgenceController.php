<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Agence;

class AgenceController extends Controller
{
    public function index(): void
    {
        $agences = (new Agence())->findAll();
        $this->render('agence/index', [
            'title'   => 'Liste des agences',
            'agences' => $agences,
        ]);
    }

    public function show($id): void
    {
        $id = (int)$id;
        if ($id <= 0) { http_response_code(400); echo 'Requête invalide.'; return; }

        $agence = (new Agence())->findById($id);
        if (!$agence) { http_response_code(404); echo 'Agence non trouvée.'; return; }

        $this->render('agence/show', [
            'title'  => 'Détails de l’agence',
            'agence' => $agence,
        ]);
    }

    // --- Admin uniquement ---

    public function createForm(): void
    {
        if (!Auth::isAdmin()) { http_response_code(403); echo 'Accès refusé.'; return; }

        $errors = $_SESSION['form_errors'] ?? [];
        $old    = $_SESSION['form_old'] ?? [];
        unset($_SESSION['form_errors'], $_SESSION['form_old']);

        $this->render('agence/create', [
            'title'  => 'Créer une agence',
            'errors' => $errors,
            'old'    => $old,
        ]);
    }

    public function create(): void
    {
        if (!Auth::isAdmin()) { http_response_code(403); echo 'Accès refusé.'; return; }

        $nom = trim($_POST['nom'] ?? '');
        if ($nom === '') {
            $_SESSION['form_errors'] = ['Le nom est requis.'];
            $_SESSION['form_old']    = $_POST;
            $this->redirect('/agences/create');
        }

        (new Agence())->create(['nom' => $nom]);
        $this->redirect('/agences');
    }

    public function edit($id): void
    {
        if (!Auth::isAdmin()) { http_response_code(403); echo 'Accès refusé.'; return; }

        $id = (int)$id;
        if ($id <= 0) { $this->redirect('/agences'); }

        $agence = (new Agence())->findById($id);
        if (!$agence) { $this->redirect('/agences'); }

        $errors = $_SESSION['form_errors'] ?? [];
        $old    = $_SESSION['form_old'] ?? [];
        unset($_SESSION['form_errors'], $_SESSION['form_old']);

        $this->render('agence/edit', [
            'title'  => 'Modifier une agence',
            'agence' => $agence,
            'errors' => $errors,
            'old'    => $old,
        ]);
    }

    public function update($id): void
    {
        if (!Auth::isAdmin()) { http_response_code(403); echo 'Accès refusé.'; return; }

        $id  = (int)$id;
        $nom = trim($_POST['nom'] ?? '');

        if ($nom === '') {
            $_SESSION['form_errors'] = ['Le nom est requis.'];
            $_SESSION['form_old']    = $_POST;
            $this->redirect("/agences/edit/{$id}");
        }

        (new Agence())->update($id, ['nom' => $nom]);
        $this->redirect('/agences');
    }

    public function delete($id): void
    {
        if (!Auth::isAdmin()) { http_response_code(403); echo 'Accès refusé.'; return; }

        $id = (int)$id;
        (new Agence())->delete($id); // ⚠️ Échouera si l’agence est référencée par un trajet
        $this->redirect('/agences');
    }

    // Note : on n’écrase PAS redirect(); on utilise celui du parent (protected dans App\Core\Controller)
}
