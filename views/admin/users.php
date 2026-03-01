<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin — Utilisateurs - Instant Valorant</title>
</head>
<body>
    <nav>
        <a href="/dashboard">Dashboard</a> |
        <a href="/games">Jeux</a> |
        <a href="/logout">Déconnexion</a>
    </nav>
    <hr>
    <h1>Gestion des utilisateurs</h1>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u->id ?></td>
                <td><?= htmlspecialchars($u->name) ?></td>
                <td><?= htmlspecialchars($u->email) ?></td>
                <td><?= htmlspecialchars($u->role ?? 'user') ?></td>
                <td>
                    <form style="display:inline" method="POST" action="/admin/users/<?= $u->id ?>/role">
                        <select name="role">
                            <option value="user" <?= ($u->role ?? 'user') === 'user' ? 'selected' : '' ?>>user</option>
                            <option value="admin" <?= ($u->role ?? '') === 'admin' ? 'selected' : '' ?>>admin</option>
                        </select>
                        <button type="submit">Changer</button>
                    </form>
                    <?php if ($u->id != $_SESSION['user_id']): ?>
                        | <form style="display:inline" method="POST" action="/admin/users/<?= $u->id ?>/delete" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            <button type="submit">Supprimer</button>
                          </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
