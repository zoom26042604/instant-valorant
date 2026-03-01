<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($game->name) ?> - Instant Valorant</title>
</head>

<body>
    <a href="/games">← Retour</a>
    <h1><?= htmlspecialchars($game->name) ?></h1>
    <p><strong>Type :</strong> <?= htmlspecialchars($game->type ?? '-') ?></p>
    <p><strong>Description :</strong> <?= htmlspecialchars($game->description ?? '-') ?></p>
    <?php if ($game->image_url): ?>
        <img src="<?= htmlspecialchars($game->image_url) ?>" alt="<?= htmlspecialchars($game->name) ?>" width="200">
    <?php endif; ?>

    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <p>
            <a href="/games/<?= $game->id ?>/edit">Modifier</a> |
        <form style="display:inline" method="POST" action="/games/<?= $game->id ?>/delete"
            onsubmit="return confirm('Supprimer ?')">
            <button type="submit">Supprimer</button>
        </form>
        </p>
    <?php endif; ?>

    <?php if (!empty($_SESSION['user_id'])): ?>
        <p><a href="/profile/games/add?game_id=<?= $game->id ?>">Ajouter à ma bibliothèque</a></p>
    <?php endif; ?>

    <h2>Niveaux</h2>
    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="/games/<?= $game->id ?>/levels/create">Ajouter un niveau</a>
    <?php endif; ?>
    <?php if (empty($levels)): ?>
        <p>Aucun niveau.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($levels as $level): ?>
                <li>
                    <strong><?= htmlspecialchars($level->name) ?></strong>
                    — <?= htmlspecialchars($level->description ?? '') ?>
                    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        | <a href="/levels/<?= $level->id ?>/edit">Modifier</a>
                        | <form style="display:inline" method="POST" action="/levels/<?= $level->id ?>/delete"
                            onsubmit="return confirm('Supprimer ?')">
                            <button type="submit">Supprimer</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Succès</h2>
    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="/games/<?= $game->id ?>/achievements/create">Ajouter un succès</a>
    <?php endif; ?>
    <?php if (empty($achievements)): ?>
        <p>Aucun succès.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($achievements as $achievement): ?>
                <li>
                    <strong><?= htmlspecialchars($achievement->name) ?></strong>
                    — <?= htmlspecialchars($achievement->description ?? '') ?>
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        | <form style="display:inline" method="POST" action="/profile/achievements/<?= $achievement->id ?>/unlock">
                            <button type="submit">Débloquer</button>
                        </form>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        | <form style="display:inline" method="POST" action="/achievements/<?= $achievement->id ?>/delete"
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