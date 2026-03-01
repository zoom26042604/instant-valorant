<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon profil - Instant Valorant</title>
</head>

<body>
    <nav>
        <a href="/games">Jeux</a> |
        <a href="/profile/achievements">Mes succès</a> |
        <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="/admin/users">Admin</a> |
        <?php endif; ?>
        <a href="/logout">Déconnexion</a>
    </nav>
    <hr>
    <h1>Profil de <?= htmlspecialchars($user->name) ?></h1>
    <p><strong>Email :</strong> <?= htmlspecialchars($user->email) ?></p>
    <p><strong>Rôle :</strong> <?= htmlspecialchars($user->role ?? 'user') ?></p>

    <h2>Ma bibliothèque</h2>
    <a href="/profile/games/add">+ Ajouter un jeu</a>
    <?php if (empty($gamesData)): ?>
        <p>Aucun jeu dans votre bibliothèque.</p>
    <?php else: ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>Jeu</th>
                <th>Type</th>
                <th>Ajouté le</th>
                <th>Temps de jeu (min)</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($gamesData as $entry): ?>
                <?php $ug = $entry['ug'];
                $game = $entry['game']; ?>
                <tr>
                    <td>
                        <?php if ($game): ?>
                            <a href="/games/<?= $game->id ?>"><?= htmlspecialchars($game->name) ?></a>
                        <?php else: ?>
                            <?= htmlspecialchars($ug->custom_name ?? '-') ?>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($game ? ($game->type ?? '-') : ($ug->custom_type ?? '-')) ?></td>
                    <td><?= htmlspecialchars($ug->date_added ?? '-') ?></td>
                    <td><?= htmlspecialchars($ug->playtime ?? '-') ?></td>
                    <td>
                        <?php if (!$game): ?>
                            <a href="/profile/games/<?= $ug->id ?>/edit">Modifier</a> |
                        <?php endif; ?>
                        <form style="display:inline" method="POST" action="/profile/games/<?= $ug->id ?>/delete"
                            onsubmit="return confirm('Retirer ?')">
                            <button type="submit">Retirer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>

</html>