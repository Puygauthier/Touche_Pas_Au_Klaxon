<?php
use App\Core\Auth;

$base     = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
$isLogged = Auth::isLoggedIn();
$title    = $title ?? 'Touche Pas Au Klaxon - Accueil';
?>

<h1>Trajets disponibles</h1>
<p class="text-muted">Trajets à venir avec places restantes (triés par date de départ).</p>

<?php if (empty($trajets)): ?>
  <div class="alert alert-warning">Aucun trajet à venir avec des places disponibles.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Départ</th>
          <th>Date départ</th>
          <th>Arrivée</th>
          <th>Date arrivée</th>
          <th>Places dispo</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($trajets as $t): ?>
        <tr>
          <td><?= htmlspecialchars($t['agence_depart_nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($t['date_heure_depart'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($t['agence_arrivee_nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($t['date_heure_arrivee'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= (int)($t['places_disponibles'] ?? 0) ?></td>
          <td>
            <a href="<?= $base ?>/trajets/show/<?= (int)$t['id'] ?>" class="btn btn-sm btn-brand">
              Détails
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php if (!$isLogged): ?>
  <div class="alert alert-info mt-3">
    Connectez-vous pour voir les informations de contact et proposer/modifier vos trajets.
    <a href="<?= $base ?>/auth/login" class="btn btn-sm btn-primary" style="margin-left:6px;">Se connecter</a>
  </div>
<?php endif; ?>
