<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Trajet;

final class HomeController extends Controller
{
    public function index(): void
    {
        $trajets = (new Trajet())->findPublic(); // futurs + places restantes, tri asc
        $this->render('home/index', [
            'title'   => 'Touche Pas Au Klaxon - Accueil',
            'trajets' => $trajets,
        ]);
    }
}
