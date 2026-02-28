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
    <a href="/logout">Se déconnecter</a>
</body>
</html>
