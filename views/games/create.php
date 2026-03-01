<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer un jeu - Instant Valorant</title>
</head>

<body>
    <a href="/games">← Retour</a>
    <h1>Créer un jeu</h1>
    <?php if (!empty($_SESSION['error'])): ?>
        <p><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST" action="/games">
        <label>Nom<br><input type="text" name="name" required></label><br><br>
        <label>Type<br><input type="text" name="type"></label><br><br>
        <label>Description<br><textarea name="description"></textarea></label><br><br>
        <label>URL de l'image<br><input type="url" name="image_url"></label><br><br>
        <button type="submit">Créer</button>
    </form>
</body>

</html>