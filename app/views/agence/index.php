<?php
use App\Core\Auth;
$base = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
$isAdmin = Auth::isAdmin();
?>

<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Liste des agences</h1>
    <?php if ($isAdmin): ?>
      <a href="<?= $base ?>/agences/create" class="btn btn-success">Créer une agence</a>
    <?php endif; ?>
  </div>

  <?php if (!empty($agences)): ?>
    <div class="card p-0">
      <ul class="list-group list-group-flush">
        <?php foreach ($agences as $agence): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><?= htmlspecialchars($agence['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            <span>
              <a href="<?= $base ?>/agences/show/<?= (int)($agence['id'] ?? 0) ?>" class="btn btn-sm btn-brand">Voir</a>
              <?php if ($isAdmin): ?>
                <a href="<?= $base ?>/agences/edit/<?= (int)($agence['id'] ?? 0) ?>" class="btn btn-sm btn-primary">Modifier</a>
                <form method="post" action="<?= $base ?>/agences/delete/<?= (int)($agence['id'] ?? 0) ?>" style="display:inline;" onsubmit="return confirm('Supprimer cette agence ?');">
                  <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                </form>
              <?php endif; ?>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php else: ?>
    <div class="alert alert-warning mt-3">Aucune agence trouvée.</div>
  <?php endif; ?>
</div>
