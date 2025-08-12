<?php
$base      = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
$loggedIn  = \App\Core\Auth::isLoggedIn();
$isAdmin   = \App\Core\Auth::isAdmin();
$user      = \App\Core\Auth::getUser();
$userId    = $user['id'] ?? null;
?>

<h1>Détails du trajet</h1>

<?php if (!empty($trajet)): ?>
  <?php
    $id       = (int)($trajet['id'] ?? 0); // utilisé pour les liens seulement
    $dep      = htmlspecialchars($trajet['agence_depart_nom'] ?? '', ENT_QUOTES, 'UTF-8');
    $arr      = htmlspecialchars($trajet['agence_arrivee_nom'] ?? '', ENT_QUOTES, 'UTF-8');
    $dhDep    = htmlspecialchars($trajet['date_heure_depart'] ?? '', ENT_QUOTES, 'UTF-8');
    $dhArr    = htmlspecialchars($trajet['date_heure_arrivee'] ?? '', ENT_QUOTES, 'UTF-8');
    $tot      = (int)($trajet['places_total'] ?? 0);
    $dispo    = (int)($trajet['places_disponibles'] ?? 0);
    $aNom     = htmlspecialchars($trajet['auteur_nom'] ?? '', ENT_QUOTES, 'UTF-8');
    $aPre     = htmlspecialchars($trajet['auteur_prenom'] ?? '', ENT_QUOTES, 'UTF-8');
    $aEmail   = htmlspecialchars($trajet['auteur_email'] ?? '', ENT_QUOTES, 'UTF-8');
    $aTel     = htmlspecialchars($trajet['auteur_telephone'] ?? '', ENT_QUOTES, 'UTF-8');
    $authorId = isset($trajet['auteur_id']) ? (int)$trajet['auteur_id'] : null;
    $canEdit  = $loggedIn && ($isAdmin || ($authorId !== null && $authorId === (int)$userId));
  ?>

  <div style="max-width:960px;">
    <table class="table table-bordered" style="background:#fff;">
      <tbody>
        <tr><th style="width:260px;">Agence départ</th><td><?= $dep ?></td></tr>
        <tr><th>Date / Heure départ</th><td><?= $dhDep ?></td></tr>
        <tr><th>Agence arrivée</th><td><?= $arr ?></td></tr>
        <tr><th>Date / Heure arrivée</th><td><?= $dhArr ?></td></tr>
        <tr><th>Places disponibles</th><td><?= $dispo ?></td></tr>
      </tbody>
    </table>

    <?php if ($loggedIn): ?>
      <div class="card p-3 mb-3">
        <h5 class="mb-2">Informations complémentaires</h5>
        <div class="mb-1"><strong>Personne à contacter :</strong> <?= $aPre . ' ' . $aNom ?></div>
        <div class="mb-1"><strong>Téléphone :</strong> <?= $aTel !== '' ? $aTel : '—' ?></div>
        <div class="mb-1"><strong>Email :</strong> <?= $aEmail !== '' ? $aEmail : '—' ?></div>
        <div class="mb-1"><strong>Nombre total de places :</strong> <?= $tot ?></div>
      </div>
    <?php else: ?>
      <div class="alert alert-info">
        Connectez-vous pour voir les informations de contact et le nombre total de places.
        <a href="<?= $base ?>/auth/login" class="btn btn-sm btn-primary" style="margin-left:6px;">Se connecter</a>
      </div>
    <?php endif; ?>

    <div class="mt-2">
      <a href="<?= $base ?>/trajets" class="btn btn-brand">Retour à la liste</a>
      <?php if ($canEdit): ?>
        <a href="<?= $base ?>/trajets/edit/<?= $id ?>" class="btn btn-primary">Modifier</a>
        <form method="post" action="<?= $base ?>/trajets/delete/<?= $id ?>" style="display:inline;" onsubmit="return confirm('Supprimer ce trajet ?');">
          <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
      <?php endif; ?>
    </div>
  </div>

<?php else: ?>
  <div class="alert alert-warning">Trajet non trouvé.</div>
<?php endif; ?>
