<?php 
$base      = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
$loggedIn  = \App\Core\Auth::isLoggedIn();
$isAdmin   = \App\Core\Auth::isAdmin();
$user      = \App\Core\Auth::getUser();
$userId    = $user['id'] ?? null;
?>

<h1>Liste des trajets</h1>

<?php if (!empty($trajets)): ?>
  <div style="overflow:auto;background:#fff;border:1px solid #e5e7eb;border-radius:10px;">
    <table class="table table-striped" style="min-width:920px;">
      <thead>
        <tr>
          <th>ID</th>
          <th>Départ</th>
          <th>Arrivée</th>
          <th>Date / Heure départ</th>
          <th>Date / Heure arrivée</th>
          <th>Places totales</th>
          <th>Places dispo</th>
          <th>Auteur</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($trajets as $t): ?>
        <?php
          $tid = (int)$t['id'];
          $authorId = isset($t['auteur_id']) ? (int)$t['auteur_id'] : null;
          $canEdit = $loggedIn && ($isAdmin || ($authorId !== null && $authorId === (int)$userId));
        ?>
        <tr>
          <td><?= $tid ?></td>
          <td><?= htmlspecialchars($t['agence_depart_nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($t['agence_arrivee_nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($t['date_heure_depart'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($t['date_heure_arrivee'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars((string)($t['places_total'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars((string)($t['places_disponibles'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars(trim(($t['auteur_nom'] ?? '').' '.($t['auteur_prenom'] ?? '')), ENT_QUOTES, 'UTF-8') ?></td>
          <td style="white-space:nowrap;">
            <a href="<?= $base ?>/trajets/show/<?= $tid ?>" class="btn btn-sm btn-brand">Voir</a>
            <?php if ($canEdit): ?>
              <a href="<?= $base ?>/trajets/edit/<?= $tid ?>" class="btn btn-sm btn-primary">Modifier</a>
              <form method="post" action="<?= $base ?>/trajets/delete/<?= $tid ?>" style="display:inline;" onsubmit="return confirm('Supprimer ce trajet ?');">
                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <div class="alert alert-warning">Aucun trajet trouvé.</div>
<?php endif; ?>
