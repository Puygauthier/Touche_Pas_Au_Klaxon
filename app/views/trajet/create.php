<?php
$base   = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
$errors = $_SESSION['form_errors'] ?? [];
$old    = $_SESSION['form_old'] ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_old']);

$user = $user ?? \App\Core\Auth::getUser();
?>
<h1>Créer un trajet</h1>

<?php if ($errors): ?>
  <div class="alert alert-danger">
    <strong>Erreurs :</strong>
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<!-- Infos utilisateur (non modifiables) -->
<div class="card p-3 mb-3">
  <h5>Vos informations</h5>
  <div><strong>Nom :</strong> <?= htmlspecialchars(($user['prenom'] ?? '').' '.($user['nom'] ?? ''), ENT_QUOTES, 'UTF-8') ?></div>
  <div><strong>Email :</strong> <?= htmlspecialchars(($user['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?></div>
  <?php if (!empty($user['telephone'])): ?>
    <div><strong>Téléphone :</strong> <?= htmlspecialchars($user['telephone'], ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>
</div>

<?php if (empty($agences)): ?>
  <div class="alert alert-warning">Aucune agence n’est disponible. Merci d’en créer dans l’espace administrateur.</div>
<?php else: ?>
<form method="post" action="<?= $base ?>/trajets/create" class="mb-3" autocomplete="off">
  <div class="row g-2">
    <div class="col-md-6">
      <label class="form-label" for="agence_depart_id">Agence départ</label>
      <select id="agence_depart_id" name="agence_depart_id" class="form-select" required>
        <option value="">-- choisir --</option>
        <?php foreach ($agences as $a): ?>
          <option value="<?= (int)$a['id'] ?>" <?= (($old['agence_depart_id'] ?? '')==(string)$a['id']?'selected':'') ?>>
            <?= htmlspecialchars($a['nom'], ENT_QUOTES, 'UTF-8') ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label" for="agence_arrivee_id">Agence arrivée</label>
      <select id="agence_arrivee_id" name="agence_arrivee_id" class="form-select" required>
        <option value="">-- choisir --</option>
        <?php foreach ($agences as $a): ?>
          <option value="<?= (int)$a['id'] ?>" <?= (($old['agence_arrivee_id'] ?? '')==(string)$a['id']?'selected':'') ?>>
            <?= htmlspecialchars($a['nom'], ENT_QUOTES, 'UTF-8') ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label" for="date_heure_depart">Date / Heure départ</label>
      <input id="date_heure_depart" type="datetime-local" name="date_heure_depart" class="form-control" required
             value="<?= htmlspecialchars($old['date_heure_depart'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label" for="date_heure_arrivee">Date / Heure arrivée</label>
      <input id="date_heure_arrivee" type="datetime-local" name="date_heure_arrivee" class="form-control" required
             value="<?= htmlspecialchars($old['date_heure_arrivee'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label" for="places_total">Places totales</label>
      <input id="places_total" type="number" name="places_total" min="1" max="8" class="form-control" required
             value="<?= htmlspecialchars($old['places_total'] ?? '4', ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label" for="places_disponibles">Places disponibles</label>
      <input id="places_disponibles" type="number" name="places_disponibles" min="0" max="8" class="form-control" required
             value="<?= htmlspecialchars($old['places_disponibles'] ?? '3', ENT_QUOTES, 'UTF-8') ?>">
    </div>
  </div>

  <button type="submit" class="btn btn-success mt-2">Créer</button>
  <a href="<?= $base ?>/trajets" class="btn btn-secondary mt-2">Annuler</a>
</form>
<?php endif; ?>
