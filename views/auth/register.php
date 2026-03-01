<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Instant Valorant</title>
</head>
<body>
    <h1>Inscription</h1>
    <?php if (!empty($_SESSION['error'])): ?>
        <p><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST" action="/register">
        <label>Nom<br><input type="text" name="name" required></label><br><br>
        <label>Email<br><input type="email" name="email" required></label><br><br>
        <label>Mot de passe<br><input type="password" name="password" required></label><br><br>
        <button type="submit">S'inscrire</button>
    </form>
    <p><a href="/login">Déjà un compte ?</a></p>
</body>
</html>
