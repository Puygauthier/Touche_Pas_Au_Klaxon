<?php
$base   = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
$errors = $_SESSION['form_errors'] ?? [];
$old    = $_SESSION['form_old'] ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_old']);
?>

<h1>Créer une agence</h1>

<?php if ($errors): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li><?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" action="<?= $base ?>/agences/create" class="mt-2">
  <div class="mb-3">
    <label class="form-label">Nom de l'agence</label>
    <input type="text" name="nom" class="form-control" required
           value="<?= htmlspecialchars($old['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
  </div>
  <button type="submit" class="btn btn-success">Créer</button>
  <a href="<?= $base ?>/agences" class="btn btn-brand">Annuler</a>
</form>
