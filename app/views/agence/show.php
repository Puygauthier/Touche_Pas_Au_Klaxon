<?php $base = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : ''; ?>

<div class="container my-4">
  <div class="card p-3">
    <h1 class="mb-3">Détails de l'agence</h1>

    <p><strong>Nom :</strong> <?= htmlspecialchars($agence['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>

    <a href="<?= $base ?>/agences" class="btn btn-secondary mt-2">Retour à la liste</a>
  </div>
</div>
