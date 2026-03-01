<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Instant Valorant</title>
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
    <p>Email : <?= htmlspecialchars($_SESSION['user_email']) ?></p>
    <nav>
        <a href="/profile">Mon profil</a> |
        <a href="/games">Jeux</a> |
        <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="/admin/users">Admin</a> |
        <?php endif; ?>
        <a href="/logout">Se déconnecter</a>
    </nav>
</body>
</html>
