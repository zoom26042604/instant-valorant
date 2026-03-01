<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/rb-postgres.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

R::setup(
    'pgsql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD']
);

// Admin user
$adminEmail = 'admin@instant-valorant.com';
$admin = R::findOne('user', 'email = ?', [$adminEmail]);
if (!$admin) {
    $admin = R::dispense('user');
    $admin->name = 'Admin';
    $admin->email = $adminEmail;
    $admin->password = password_hash('admin1234', PASSWORD_ARGON2ID);
    $admin->role = 'admin';
    R::store($admin);
    echo "Admin cree : $adminEmail / admin1234\n";
} else {
    echo "Admin existe deja.\n";
}

// 5 games
$games = [
    ['name' => 'League of Legends', 'type' => 'MOBA', 'description' => 'Affronte tes ennemis sur la Faille de l\'Invocateur en equipes de 5.'],
    ['name' => 'Valorant', 'type' => 'FPS', 'description' => 'Shooter tactique 5v5 avec des agents aux capacites uniques.'],
    ['name' => 'Mario Kart', 'type' => 'Racing', 'description' => 'Course avec les personnages iconiques Nintendo sur des circuits delirants.'],
    ['name' => 'Avatar: Frontiers of Pandora', 'type' => 'Action-Adventure', 'description' => 'Explore Pandora et combats pour proteger ta terre natale.'],
    ['name' => 'Skyrim', 'type' => 'RPG', 'description' => 'Incarne le Dovahkiin et explore la province de Bordeciel.'],
];

foreach ($games as $g) {
    if (!R::findOne('game', 'name = ?', [$g['name']])) {
        $game = R::dispense('game');
        $game->name = $g['name'];
        $game->type = $g['type'];
        $game->description = $g['description'];
        $game->image_url = null;
        R::store($game);
        echo "Jeu cree : {$g['name']}\n";
    } else {
        echo "Jeu existe deja : {$g['name']}\n";
    }
}

echo "\nSeed termine !\n";
