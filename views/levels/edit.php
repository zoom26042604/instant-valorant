<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le niveau - Instant Valorant</title>
</head>
<body>
    <a href="/games/<?= $game->id ?>">← Retour</a>
    <h1>Modifier le niveau : <?= htmlspecialchars($level->name) ?></h1>
    <?php if (!empty($_SESSION['error'])): ?>
        <p><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST" action="/levels/<?= $level->id ?>/update">
        <label>Nom<br><input type="text" name="name" value="<?= htmlspecialchars($level->name) ?>" required></label><br><br>
        <label>Description<br><textarea name="description"><?= htmlspecialchars($level->description ?? '') ?></textarea></label><br><br>
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
