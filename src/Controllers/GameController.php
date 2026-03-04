<?php

namespace App\Controllers;

use R;
use App\Helpers\Auth;

class GameController
{
    public function index(): void
    {
        $games = R::findAll('game');
        echo json_encode(R::exportAll($games));
    }

    public function show(int $id): void
    {
        $game = R::load('game', $id);
        if (!$game->id) {
            http_response_code(404);
            echo json_encode(['error' => 'Game not found']);
            return;
        }
        echo json_encode($game->export());
    }

    public function store(array $data): void
    {
        Auth::requireAdmin();
        if (empty($data['name'])) {
            http_response_code(422);
            echo json_encode(['error' => 'Name is required']);
            return;
        }
        $game = R::dispense('game');
        $game->name = $data['name'];
        $game->type = $data['type'] ?? null;
        $game->description = $data['description'] ?? null;
        $game->image_url = $data['image_url'] ?? null;
        $id = R::store($game);
        http_response_code(201);
        echo json_encode(['id' => $id, 'message' => 'Game created']);
    }

    public function update(int $id, array $data): void
    {
        Auth::requireAdmin();
        $game = R::load('game', $id);
        if (!$game->id) {
            http_response_code(404);
            echo json_encode(['error' => 'Game not found']);
            return;
        }
        if (isset($data['name'])) $game->name = $data['name'];
        if (isset($data['type'])) $game->type = $data['type'];
        if (isset($data['description'])) $game->description = $data['description'];
        if (isset($data['image_url'])) $game->image_url = $data['image_url'];
        R::store($game);
        echo json_encode(['message' => 'Game updated']);
    }

    public function destroy(int $id): void
    {
        Auth::requireAdmin();
        $game = R::load('game', $id);
        if (!$game->id) {
            http_response_code(404);
            echo json_encode(['error' => 'Game not found']);
            return;
        }
        $this->cascadeDeleteGame($id);
        R::trash($game);
        echo json_encode(['message' => 'Game deleted']);
    }

    public function seed(): void
    {
        Auth::requireAdmin();
        $games = [
            [
                'name' => 'League of Legends',
                'type' => 'MOBA',
                'description' => 'Affronte tes ennemis sur la Faille de l\'Invocateur en équipes de 5.',
                'achievements' => [
                    ['name' => 'Bienvenue sur la Faille', 'description' => 'Ajoute League of Legends à ta bibliothèque et prends place sur la Faille de l\'Invocateur.'],
                    ['name' => 'Premier Sang', 'description' => 'Inflige la première mort de la partie avant tout le monde — la légende commence ici.'],
                    ['name' => 'Pentakill !', 'description' => 'Élimine les 5 ennemis adverses consécutivement. Une prouesse digne des grands.'],
                    ['name' => 'Architecte des Runes', 'description' => 'Configure un set de runes personnalisé adapté à ton style de jeu.'],
                    ['name' => 'Ascension vers l\'Or', 'description' => 'Atteins le rang Or en file classée pour la première fois de ta carrière.'],
                ],
            ],
            [
                'name' => 'Valorant',
                'type' => 'Tir tactique',
                'description' => 'Shooter tactique 5v5 avec des agents aux capacités uniques.',
                'achievements' => [
                    ['name' => 'Recrue du Protocole', 'description' => 'Rejoins le Protocole en ajoutant Valorant à ta bibliothèque.'],
                    ['name' => 'Sang Froid', 'description' => 'Élimine le premier ennemi de la partie avec un tir précis à la tête.'],
                    ['name' => 'Maître des Agents', 'description' => 'Joue une partie complète avec 5 agents différents pour maîtriser le Protocole.'],
                    ['name' => 'Clutch Implacable', 'description' => 'Retourne une situation 1 contre 3 (ou plus) pour sauver ta team.'],
                    ['name' => 'Diamant Brut', 'description' => 'Atteins le rang Diamant en compétitif — tu fais partie de l\'élite.'],
                ],
            ],
            [
                'name' => 'Mario Kart',
                'type' => 'Course',
                'description' => 'Course avec les personnages iconiques Nintendo sur des circuits délirants.',
                'achievements' => [
                    ['name' => 'En Piste !', 'description' => 'Ajoute Mario Kart à ta bibliothèque et démarre les moteurs.'],
                    ['name' => 'Champion du Circuit', 'description' => 'Termine une coupe entière en première position sans regarder derrière.'],
                    ['name' => 'Victime de la Carapace Bleue', 'description' => 'Reçois une Carapace Bleue en étant premier — le prix de la gloire.'],
                    ['name' => 'Pilote sans Faute', 'description' => 'Termine un Grand Prix en 150cc sans tomber hors piste une seule fois.'],
                    ['name' => 'Triple Étoile', 'description' => 'Obtiens 3 étoiles sur une coupe complète en difficulté maximale.'],
                ],
            ],
            [
                'name' => 'Avatar: Frontiers of Pandora',
                'type' => 'Action-Aventure',
                'description' => 'Explore Pandora et combats pour protéger ta terre natale.',
                'achievements' => [
                    ['name' => 'Fils de la Forêt', 'description' => 'Ajoute Avatar: Frontiers of Pandora à ta bibliothèque et foule le sol de Pandora.'],
                    ['name' => 'Premier Vol', 'description' => 'Établis un lien avec un ikran et prends ton envol pour la première fois au-dessus des forêts.'],
                    ['name' => 'Libérateur', 'description' => 'Reprends le contrôle d\'un avant-poste occupé par les forces de la RDA.'],
                    ['name' => 'Chasseur Na\'vi', 'description' => 'Chasse une proie sauvage et prépare un repas en utilisant uniquement des ressources naturelles de Pandora.'],
                    ['name' => 'Voix d\'Eywa', 'description' => 'Connecte-toi à un arbre sacré et ressens le lien spirituel avec Eywa pour la première fois.'],
                ],
            ],
            [
                'name' => 'Skyrim',
                'type' => 'Jeu de rôle',
                'description' => 'Incarne le Dovahkiin et explore la province de Bordeciel.',
                'achievements' => [
                    ['name' => 'Novice de Bordeciel', 'description' => 'Ajoute Skyrim à ta bibliothèque et pose le pied dans la province gelée de Bordeciel.'],
                    ['name' => 'Dévoreur d\'Âmes', 'description' => 'Tue un dragon et absorbe son âme pour la première fois — tu es le Dovahkiin.'],
                    ['name' => 'Forgeron Draconique', 'description' => 'Forge ton premier objet en os ou écaille de dragon au rang de qualité maximale.'],
                    ['name' => 'Compagnon d\'Armes', 'description' => 'Rejoins la guilde des Compagnons à Blancherive et prête serment.'],
                    ['name' => 'Fus Ro Dah !', 'description' => 'Utilise le Cri de la Force ininterrompue (Fus Ro Dah) pour projeter un ennemi en combat.'],
                ],
            ],
        ];

        $gamesCount = 0;
        $achCount = 0;
        foreach ($games as $g) {
            $existing = R::findOne('game', 'name = ?', [$g['name']]);
            if (!$existing) {
                $game = R::dispense('game');
                $game->name = $g['name'];
                $game->type = $g['type'];
                $game->description = $g['description'];
                $game->image_url = null;
                R::store($game);
                $gameId = $game->id;
                $gamesCount++;
            } else {
                $gameId = $existing->id;
            }
            foreach ($g['achievements'] as $achData) {
                if (!R::findOne('achievement', 'game_id = ? AND name = ?', [$gameId, $achData['name']])) {
                    $a = R::dispense('achievement');
                    $a->game_id = $gameId;
                    $a->name = $achData['name'];
                    $a->description = $achData['description'];
                    R::store($a);
                    $achCount++;
                }
            }
        }
        echo json_encode(['message' => "$gamesCount jeux et $achCount succès ajoutés"]);
    }

    public function webStore(array $data): void
    {
        Auth::webRequireAdmin();
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Name is required';
            header('Location: /games/create');
            exit;
        }
        $game = R::dispense('game');
        $game->name = $data['name'];
        $game->type = $data['type'] ?? null;
        $game->description = $data['description'] ?? null;
        $game->image_url = $data['image_url'] ?? null;
        $id = R::store($game);
        header("Location: /games/$id");
        exit;
    }

    public function webUpdate(int $id, array $data): void
    {
        Auth::webRequireAdmin();
        $game = R::load('game', $id);
        if (!$game->id) {
            http_response_code(404);
            echo '404 Not Found';
            exit;
        }
        if (isset($data['name'])) $game->name = $data['name'];
        if (isset($data['type'])) $game->type = $data['type'];
        if (isset($data['description'])) $game->description = $data['description'];
        if (isset($data['image_url'])) $game->image_url = $data['image_url'];
        R::store($game);
        header("Location: /games/$id");
        exit;
    }

    public function webDestroy(int $id): void
    {
        Auth::webRequireAdmin();
        $game = R::load('game', $id);
        if ($game->id) {
            $this->cascadeDeleteGame($id);
            R::trash($game);
        }
        header('Location: /games');
        exit;
    }

    private function cascadeDeleteGame(int $gameId): void
    {
        $achievements = R::find('achievement', 'game_id = ?', [$gameId]);
        foreach ($achievements as $achievement) {
            R::exec('DELETE FROM userachievement WHERE achievement_id = ?', [$achievement->id]);
            R::trash($achievement);
        }
    }
}
