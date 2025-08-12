<?php
$base = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
?>

<h1>Détails utilisateur</h1>

<?php if (!empty($user)): ?>
  <ul class="list-group mb-4">
    <li class="list-group-item"><strong>ID :</strong> <?= htmlspecialchars($user['id']) ?></li>
    <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></li>
    <li class="list-group-item"><strong>Prénom :</strong> <?= htmlspecialchars($user['prenom']) ?></li>
    <li class="list-group-item"><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></li>
    <li class="list-group-item"><strong>Téléphone :</strong> <?= htmlspecialchars($user['telephone']) ?></li>
    <li class="list-group-item"><strong>Rôle :</strong> <?= htmlspecialchars($user['role']) ?></li>
  </ul>

  <a href="<?= $base ?>/users" class="btn btn-brand">Retour à la liste</a>
<?php else: ?>
  <div class="alert alert-warning">Utilisateur non trouvé.</div>
<?php endif; ?>
