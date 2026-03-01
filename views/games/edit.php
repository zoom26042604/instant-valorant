<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier <?= htmlspecialchars($game->name) ?> - Instant Valorant</title>
</head>

<body>
    <a href="/games/<?= $game->id ?>">← Retour</a>
    <h1>Modifier <?= htmlspecialchars($game->name) ?></h1>
    <?php if (!empty($_SESSION['error'])): ?>
        <p><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST" action="/games/<?= $game->id ?>/update">
        <label>Nom<br><input type="text" name="name" value="<?= htmlspecialchars($game->name) ?>"
                required></label><br><br>
        <label>Type<br><input type="text" name="type"
                value="<?= htmlspecialchars($game->type ?? '') ?>"></label><br><br>
        <label>Description<br><textarea
                name="description"><?= htmlspecialchars($game->description ?? '') ?></textarea></label><br><br>
        <label>URL de l'image<br><input type="url" name="image_url"
                value="<?= htmlspecialchars($game->image_url ?? '') ?>"></label><br><br>
        <button type="submit">Enregistrer</button>
    </form>
</body>

</html>