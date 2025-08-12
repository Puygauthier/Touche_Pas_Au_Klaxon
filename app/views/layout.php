<?php
use App\Core\Auth;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$user       = Auth::getUser();
$isLoggedIn = Auth::isLoggedIn();
$isAdmin    = Auth::isAdmin();

$base  = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
$title = $title ?? 'Touche Pas Au Klaxon';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base ?>/css/style.css">
</head>
<body>
<header>
  <!-- Conteneur centré avec marge interne pour éviter les bords -->
  <div style="width:100%; box-sizing:border-box;">
    <div style="
      max-width: 1120px;
      margin: 0 auto;
      padding: 12px 24px;
      display:flex;
      align-items:center;
      gap:16px;
    ">
      <!-- Logo / Titre -->
      <div>
        <?php if ($isAdmin): ?>
          <a href="<?= $base ?>/admin/dashboard" style="font-weight:bold; font-size:1.2em; display:inline-block;">
            Touche Pas Au Klaxon
          </a>
        <?php else: ?>
          <a href="<?= $base ?>/" style="font-weight:bold; font-size:1.2em; display:inline-block;">
            Touche Pas Au Klaxon
          </a>
        <?php endif; ?>
      </div>

      <!-- Espace flexible pour pousser la nav à droite -->
      <div style="flex:1;"></div>

      <!-- Navigation (AUCUN bouton Modifier/Supprimer ici) -->
      <nav style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <?php if (!$isLoggedIn): ?>
          <a href="<?= $base ?>/auth/login" class="btn btn-primary">Se connecter</a>

        <?php elseif ($isAdmin): ?>
          <a href="<?= $base ?>/users" class="btn btn-link">Utilisateurs</a>
          <a href="<?= $base ?>/agences" class="btn btn-link">Agences</a>
          <a href="<?= $base ?>/trajets" class="btn btn-link">Trajets</a>
          <a href="<?= $base ?>/auth/logout" class="btn btn-danger">Déconnexion</a>

        <?php else: ?>
          <a href="<?= $base ?>/trajets/create" class="btn btn-success">Créer un trajet</a>
          <span><?= htmlspecialchars(($user['prenom'] ?? '').' '.($user['nom'] ?? ''), ENT_QUOTES, 'UTF-8') ?></span>
          <a href="<?= $base ?>/auth/logout" class="btn btn-danger">Déconnexion</a>
        <?php endif; ?>
      </nav>
    </div>
  </div>
  <hr>
</header>

<main>
  <?= $content ?>
</main>

<footer>
  <hr>
  <p>&copy; <?= date('Y') ?> Touche Pas Au Klaxon - Tous droits réservés</p>
</footer>
</body>
</html>
