<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instant Valorant</title>
</head>
<body>
    <h1>Instant Valorant</h1>
    <nav>
        <a href="/games">Jeux</a> |
        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="/profile">Mon profil</a> |
            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="/admin/users">Admin</a> |
            <?php endif; ?>
            <a href="/logout">Déconnexion</a>
        <?php else: ?>
            <a href="/login">Connexion</a> |
            <a href="/register">Inscription</a>
        <?php endif; ?>
    </nav>
    <hr>
    <p>Bienvenue sur la plateforme. Consulte les <a href="/games">jeux disponibles</a> ou connecte-toi pour gérer ta bibliothèque.</p>
</body>
</html>
