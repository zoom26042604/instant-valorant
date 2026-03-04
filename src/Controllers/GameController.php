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
            ['name' => 'League of Legends', 'type' => 'MOBA', 'description' => 'Affronte tes ennemis sur la Faille de l\'Invocateur en équipes de 5.'],
            ['name' => 'Valorant', 'type' => 'Tir tactique', 'description' => 'Shooter tactique 5v5 avec des agents aux capacités uniques.'],
            ['name' => 'Mario Kart', 'type' => 'Course', 'description' => 'Course avec les personnages iconiques Nintendo sur des circuits délirants.'],
            ['name' => 'Avatar: Frontiers of Pandora', 'type' => 'Action-Aventure', 'description' => 'Explore Pandora et combats pour protéger ta terre natale.'],
            ['name' => 'Skyrim', 'type' => 'Jeu de rôle', 'description' => 'Incarne le Dovahkiin et explore la province de Bordeciel.'],
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
            if (!R::findOne('achievement', 'game_id = ? AND name = ?', [$gameId, 'Débutant'])) {
                $a = R::dispense('achievement');
                $a->game_id = $gameId;
                $a->name = 'Débutant';
                $a->description = 'Premier pas sur ' . $g['name'] . ' — ajoute ce jeu à ta bibliothèque.';
                R::store($a);
                $achCount++;
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
