<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un niveau - <?= htmlspecialchars($game->name) ?></title>
</head>
<body>
    <a href="/games/<?= $game->id ?>">← Retour</a>
    <h1>Ajouter un niveau — <?= htmlspecialchars($game->name) ?></h1>
    <?php if (!empty($_SESSION['error'])): ?>
        <p><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST" action="/games/<?= $game->id ?>/levels">
        <label>Nom<br><input type="text" name="name" required></label><br><br>
        <label>Description<br><textarea name="description"></textarea></label><br><br>
        <button type="submit">Créer</button>
    </form>
</body>
</html>
