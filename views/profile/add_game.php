<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un jeu - Mon profil</title>
</head>
<body>
    <a href="/profile">← Retour</a>
    <h1>Ajouter un jeu à ma bibliothèque</h1>
    <?php if (!empty($_SESSION['error'])): ?>
        <p><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h2>Choisir un jeu de la plateforme</h2>
    <form method="POST" action="/profile/games">
        <label>Jeu
            <br>
            <select name="game_id">
                <option value="">-- Sélectionner --</option>
                <?php foreach ($games as $game): ?>
                    <option value="<?= $game->id ?>" <?= $preselected == $game->id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($game->name) ?> (<?= htmlspecialchars($game->type ?? '') ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <br><br>
        <button type="submit">Ajouter</button>
    </form>

    <hr>

    <h2>Ajouter un jeu personnalisé</h2>
    <form method="POST" action="/profile/games">
        <label>Nom<br><input type="text" name="custom_name" required></label><br><br>
        <label>Type<br><input type="text" name="custom_type"></label><br><br>
        <label>Description<br><textarea name="custom_description"></textarea></label><br><br>
        <label>URL de l'image<br><input type="url" name="custom_image_url"></label><br><br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
