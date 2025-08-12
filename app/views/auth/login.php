<?php
$base = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
$error = $error ?? null;
$oldEmail = htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<h1>Connexion</h1>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form method="post" action="<?= $base ?>/auth/login" style="max-width:420px;display:grid;gap:10px;">
  <label for="email">Adresse email</label>
  <input type="email" id="email" name="email" class="form-control" required value="<?= $oldEmail ?>">

  <label for="password">Mot de passe</label>
  <input type="password" id="password" name="password" class="form-control" required>

  <button type="submit" class="btn btn-primary mt-2">Se connecter</button>
</form>

