<?php
use App\Core\Auth;

$base   = defined('BASE_PATH') ? rtrim(BASE_PATH, '/') : '';
$isAdmin = Auth::isAdmin();
?>

<h1>Liste des utilisateurs</h1>

<?php if (!empty($users)): ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <?php if ($isAdmin): ?><th>ID</th><?php endif; ?>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $u): ?>
      <tr>
        <?php if ($isAdmin): ?><td><?= (int)$u['id'] ?></td><?php endif; ?>
        <td><?= htmlspecialchars($u['nom'] ?? '') ?></td>
        <td><?= htmlspecialchars($u['prenom'] ?? '') ?></td>
        <td><?= htmlspecialchars($u['email'] ?? '') ?></td>
        <td>
          <a href="<?= $base ?>/users/show/<?= (int)$u['id'] ?>" class="btn btn-sm btn-brand">Voir</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <div class="alert alert-warning">Aucun utilisateur trouvé.</div>
<?php endif; ?>
