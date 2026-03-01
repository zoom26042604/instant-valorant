<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Instant Valorant</title>
</head>
<body>
    <h1>Connexion</h1>
    <?php if (!empty($_SESSION['error'])): ?>
        <p><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST" action="/login">
        <label>Email<br><input type="email" name="email" required></label><br><br>
        <label>Mot de passe<br><input type="password" name="password" required></label><br><br>
        <button type="submit">Se connecter</button>
    </form>
    <p><a href="/register">Pas encore de compte ?</a></p>
</body>
</html>
