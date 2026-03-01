<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes succès - Instant Valorant</title>
</head>
<body>
    <a href="/profile">← Retour au profil</a>
    <h1>Mes succès</h1>
    <?php if (empty($achievementsData)): ?>
        <p>Vous n'avez encore débloqué aucun succès. <a href="/games">Parcourir les jeux</a></p>
    <?php else: ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>Succès</th>
                <th>Description</th>
                <th>Débloqué le</th>
            </tr>
            <?php foreach ($achievementsData as $entry): ?>
                <?php $ua = $entry['ua']; $a = $entry['achievement']; ?>
                <tr>
                    <td><?= htmlspecialchars($a->name ?? '-') ?></td>
                    <td><?= htmlspecialchars($a->description ?? '-') ?></td>
                    <td><?= htmlspecialchars($ua->unlocked_at ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
