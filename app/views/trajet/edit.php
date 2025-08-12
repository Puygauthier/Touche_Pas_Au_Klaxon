<?php
$base = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
?>
<div style="max-width:800px;margin:24px auto;padding:8px;">
  <h1 style="margin:0 0 12px;">Modifier le trajet #<?= (int)$trajet['id'] ?></h1>

  <form method="post" action="<?= $base ?>/trajets/update/<?= (int)$trajet['id'] ?>" style="border:1px solid #e5e7eb;border-radius:10px;padding:12px;background:#fff;">
    <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;">

      <label>Agence départ
        <select name="agence_depart_id" required>
          <?php foreach ($agences as $a): ?>
            <option value="<?= (int)$a['id'] ?>" <?= ((int)$trajet['agence_depart_id']===(int)$a['id']?'selected':'') ?>>
              <?= htmlspecialchars($a['nom'], ENT_QUOTES, 'UTF-8') ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>

      <label>Agence arrivée
        <select name="agence_arrivee_id" required>
          <?php foreach ($agences as $a): ?>
            <option value="<?= (int)$a['id'] ?>" <?= ((int)$trajet['agence_arrivee_id']===(int)$a['id']?'selected':'') ?>>
              <?= htmlspecialchars($a['nom'], ENT_QUOTES, 'UTF-8') ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>

      <label>Date / Heure départ
        <input type="datetime-local" name="date_heure_depart" required
               value="<?= htmlspecialchars(str_replace(' ', 'T', (string)$trajet['date_heure_depart']), ENT_QUOTES, 'UTF-8') ?>">
      </label>

      <label>Date / Heure arrivée
        <input type="datetime-local" name="date_heure_arrivee" required
               value="<?= htmlspecialchars(str_replace(' ', 'T', (string)$trajet['date_heure_arrivee']), ENT_QUOTES, 'UTF-8') ?>">
      </label>

      <label>Places totales
        <input type="number" min="1" max="8" name="places_total" required value="<?= (int)$trajet['places_total'] ?>">
      </label>

      <label>Places disponibles
        <input type="number" min="0" max="8" name="places_disponibles" required value="<?= (int)$trajet['places_disponibles'] ?>">
      </label>
    </div>

    <div style="margin-top:12px;display:flex;gap:8px;">
      <button type="submit" class="btn btn-primary">Enregistrer</button>
      <a href="<?= $base ?>/trajets" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>
