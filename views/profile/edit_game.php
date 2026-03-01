<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le jeu - Mon profil</title>
</head>
<body>
    <a href="/profile">← Retour</a>
    <h1>Modifier le jeu personnalisé</h1>
    <?php if (!empty($_SESSION['error'])): ?>
        <p><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST" action="/profile/games/<?= $userGame->id ?>/update">
        <label>Nom<br><input type="text" name="custom_name" value="<?= htmlspecialchars($userGame->custom_name ?? '') ?>" required></label><br><br>
        <label>Type<br><input type="text" name="custom_type" value="<?= htmlspecialchars($userGame->custom_type ?? '') ?>"></label><br><br>
        <label>Description<br><textarea name="custom_description"><?= htmlspecialchars($userGame->custom_description ?? '') ?></textarea></label><br><br>
        <label>URL de l'image<br><input type="url" name="custom_image_url" value="<?= htmlspecialchars($userGame->custom_image_url ?? '') ?>"></label><br><br>
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
