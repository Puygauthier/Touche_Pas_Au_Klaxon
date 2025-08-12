<?php $base = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : ''; ?>

<h1>Tableau de bord administrateur</h1>

<div class="row g-3 my-3">
  <div class="col-md-4">
    <div class="card p-3">
      <h5 class="mb-1">Utilisateurs</h5>
      <div class="display-6"><?= (int)($counts['users'] ?? 0) ?></div>
      <a class="btn btn-sm btn-brand mt-2" href="<?= $base ?>/users">Voir la liste</a>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card p-3">
      <h5 class="mb-1">Agences</h5>
      <div class="display-6"><?= (int)($counts['agences'] ?? 0) ?></div>
      <div class="mt-2">
        <a class="btn btn-sm btn-brand" href="<?= $base ?>/agences">Voir la liste</a>
        <a class="btn btn-sm btn-success" href="<?= $base ?>/agences/create">Créer une agence</a>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card p-3">
      <h5 class="mb-1">Trajets</h5>
      <div class="display-6"><?= (int)($counts['trajets'] ?? 0) ?></div>
      <a class="btn btn-sm btn-brand mt-2" href="<?= $base ?>/trajets">Voir la liste</a>
    </div>
  </div>
</div>
