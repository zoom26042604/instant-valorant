<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Jeux - Instant Valorant</title>
</head>

<body>
    <h1>Jeux disponibles</h1>
    <nav>
        <a href="/">Accueil</a> |
        <a href="/profile">Mon profil</a> |
        <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="/games/create">Ajouter un jeu</a> |
            <a href="/api/games/seed"
                onclick="fetch('/api/games/seed',{method:'POST'}).then(r=>r.json()).then(d=>alert(d.message));return false;">Seeder
                les jeux</a> |
            <a href="/admin/users">Admin users</a> |
        <?php endif; ?>
        <a href="/logout">Déconnexion</a>
    </nav>
    <hr>
    <?php if (empty($games)): ?>
        <p>Aucun jeu disponible. <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?><a
                    href="/games/create">Ajouter le premier</a><?php endif; ?></p>
    <?php else: ?>
        <ul>
            <?php foreach ($games as $game): ?>
                <li>
                    <a href="/games/<?= $game->id ?>"><?= htmlspecialchars($game->name) ?></a>
                    — <?= htmlspecialchars($game->type ?? '') ?>
                    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        | <a href="/games/<?= $game->id ?>/edit">Modifier</a>
                        | <form style="display:inline" method="POST" action="/games/<?= $game->id ?>/delete"
                            onsubmit="return confirm('Supprimer ?')">
                            <button type="submit">Supprimer</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>