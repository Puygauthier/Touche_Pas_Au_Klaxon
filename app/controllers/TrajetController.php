<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Trajet;
use App\Models\Agence;

class TrajetController extends Controller
{
    public function index(): void
    {
        // Garde agences si ta vue index a encore l’ancien formulaire intégré
        $trajets = (new Trajet())->findAll();
        $agences = (new Agence())->findAll();

        $this->render('trajet/index', [
            'title'   => 'Liste des trajets',
            'trajets' => $trajets,
            'agences' => $agences,
        ]);
    }

    public function show($id): void
    {
        $id = (int)$id;
        if ($id <= 0) { http_response_code(400); echo 'Requête invalide.'; return; }

        $trajet = (new Trajet())->findById($id);
        if (!$trajet) { http_response_code(404); echo 'Trajet non trouvé.'; return; }

        $this->render('trajet/show', [
            'title'  => 'Détails du trajet',
            'trajet' => $trajet,
        ]);
    }

    /** GET /trajets/create : page de création (formulaire séparé) */
    public function createForm(): void
    {
        if (!Auth::isLoggedIn()) { $this->redirect('/auth/login'); }

        $agences = (new Agence())->findAll();
        $user    = Auth::getUser();

        $this->render('trajet/create', [
            'title'   => 'Créer un trajet',
            'agences' => $agences,
            'user'    => $user,
        ]);
    }

    /** POST /trajets/create : traitement + validations serveur */
    public function create(): void
    {
        if (!Auth::isLoggedIn()) { $this->redirect('/auth/login'); }

        $errors = [];
        $depId  = (int)($_POST['agence_depart_id'] ?? 0);
        $arrId  = (int)($_POST['agence_arrivee_id'] ?? 0);
        $dhDep  = str_replace('T', ' ', trim((string)($_POST['date_heure_depart'] ?? '')));
        $dhArr  = str_replace('T', ' ', trim((string)($_POST['date_heure_arrivee'] ?? '')));
        $tot    = (int)($_POST['places_total'] ?? 0);
        $dispo  = (int)($_POST['places_disponibles'] ?? 0);

        if ($depId <= 0 || $arrId <= 0)   $errors[] = "Agences départ/arrivée requises";
        if ($depId === $arrId)            $errors[] = "Départ et arrivée doivent être différents";
        if ($dhDep === '' || $dhArr === '') $errors[] = "Dates départ/arrivée requises";
        if ($tot < 1)                     $errors[] = "Places totales doit être >= 1";
        if ($dispo < 0 || $dispo > $tot)  $errors[] = "Places disponibles entre 0 et le total";
        if ($dhDep !== '' && $dhArr !== '' && strtotime($dhArr) <= strtotime($dhDep)) {
            $errors[] = "On ne peut pas arriver avant (ou à) l'heure de départ";
        }

        if ($errors) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old']    = $_POST;
            $this->redirect('/trajets/create');
        }

        $u = Auth::getUser();

        // ⚠️ utilise insert() (générique du Model), pas create()
        (new Trajet())->insert([
            'agence_depart_id'   => $depId,
            'agence_arrivee_id'  => $arrId,
            'date_heure_depart'  => $dhDep,
            'date_heure_arrivee' => $dhArr,
            'places_total'       => $tot,
            'places_disponibles' => $dispo,
            'auteur_id'          => (int)$u['id'],
        ]);

        $this->redirect('/trajets');
    }

    public function edit($id): void
    {
        if (!Auth::isLoggedIn()) { $this->redirect('/auth/login'); }

        $id = (int)$id;
        if ($id <= 0) { $this->redirect('/trajets'); }

        $trajet = (new Trajet())->findById($id);
        if (!$trajet) { $this->redirect('/trajets'); }

        // Permission : auteur ou admin
        $u = Auth::getUser();
        if (!Auth::isAdmin() && (int)$trajet['auteur_id'] !== (int)$u['id']) {
            http_response_code(403); echo 'Accès refusé.'; return;
        }

        $agences = (new Agence())->findAll();

        $this->render('trajet/edit', [
            'title'   => 'Modifier un trajet',
            'trajet'  => $trajet,
            'agences' => $agences,
        ]);
    }

    public function update($id): void
    {
        if (!Auth::isLoggedIn()) { $this->redirect('/auth/login'); }
        $id = (int)$id;
        if ($id <= 0) { $this->redirect('/trajets'); }

        $trajet = (new Trajet())->findById($id);
        if (!$trajet) { $this->redirect('/trajets'); }

        $u = Auth::getUser();
        if (!Auth::isAdmin() && (int)$trajet['auteur_id'] !== (int)$u['id']) {
            http_response_code(403); echo 'Accès refusé.'; return;
        }

        $depId  = (int)($_POST['agence_depart_id'] ?? 0);
        $arrId  = (int)($_POST['agence_arrivee_id'] ?? 0);
        $dhDep  = str_replace('T', ' ', trim((string)($_POST['date_heure_depart'] ?? '')));
        $dhArr  = str_replace('T', ' ', trim((string)($_POST['date_heure_arrivee'] ?? '')));
        $tot    = (int)($_POST['places_total'] ?? 0);
        $dispo  = (int)($_POST['places_disponibles'] ?? 0);

        $errors = [];
        if ($depId <= 0 || $arrId <= 0)   $errors[] = "Agences départ/arrivée requises";
        if ($depId === $arrId)            $errors[] = "Départ et arrivée doivent être différents";
        if ($dhDep === '' || $dhArr === '') $errors[] = "Dates départ/arrivée requises";
        if ($tot < 1)                     $errors[] = "Places totales doit être >= 1";
        if ($dispo < 0 || $dispo > $tot)  $errors[] = "Places disponibles entre 0 et le total";
        if ($dhDep !== '' && $dhArr !== '' && strtotime($dhArr) <= strtotime($dhDep)) {
            $errors[] = "On ne peut pas arriver avant (ou à) l'heure de départ";
        }

        if ($errors) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old']    = $_POST;
            $this->redirect("/trajets/edit/{$id}");
        }

        (new Trajet())->update($id, [
            'agence_depart_id'   => $depId,
            'agence_arrivee_id'  => $arrId,
            'date_heure_depart'  => $dhDep,
            'date_heure_arrivee' => $dhArr,
            'places_total'       => $tot,
            'places_disponibles' => $dispo,
        ]);

        $this->redirect('/trajets');
    }

    public function delete($id): void
    {
        if (!Auth::isLoggedIn()) { $this->redirect('/auth/login'); }
        $id = (int)$id;
        if ($id <= 0) { $this->redirect('/trajets'); }

        $trajet = (new Trajet())->findById($id);
        if (!$trajet) { $this->redirect('/trajets'); }

        $u = Auth::getUser();
        if (!Auth::isAdmin() && (int)$trajet['auteur_id'] !== (int)$u['id']) {
            http_response_code(403); echo 'Accès refusé.'; return;
        }

        (new Trajet())->delete($id);
        $this->redirect('/trajets');
    }
}
