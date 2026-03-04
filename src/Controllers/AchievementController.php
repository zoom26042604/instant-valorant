<?php

namespace App\Controllers;

use R;
use App\Helpers\Auth;

class AchievementController
{
    public function index(int $gameId): void
    {
        $achievements = R::find('achievement', 'game_id = ?', [$gameId]);
        echo json_encode(R::exportAll($achievements));
    }

    public function store(int $gameId, array $data): void
    {
        Auth::requireAdmin();
        $game = R::load('game', $gameId);
        if (!$game->id) {
            http_response_code(404);
            echo json_encode(['error' => 'Game not found']);
            return;
        }
        if (empty($data['name'])) {
            http_response_code(422);
            echo json_encode(['error' => 'Name is required']);
            return;
        }
        if (R::findOne('achievement', 'game_id = ? AND name = ?', [$gameId, $data['name']])) {
            http_response_code(409);
            echo json_encode(['error' => 'Achievement already exists for this game']);
            return;
        }
        $achievement = R::dispense('achievement');
        $achievement->game_id = $gameId;
        $achievement->name = $data['name'];
        $achievement->description = $data['description'] ?? null;
        $id = R::store($achievement);
        http_response_code(201);
        echo json_encode(['id' => $id, 'message' => 'Achievement created']);
    }

    public function destroy(int $id): void
    {
        Auth::requireAdmin();
        $achievement = R::load('achievement', $id);
        if (!$achievement->id) {
            http_response_code(404);
            echo json_encode(['error' => 'Achievement not found']);
            return;
        }
        R::trash($achievement);
        echo json_encode(['message' => 'Achievement deleted']);
    }

    public function webStore(int $gameId, array $data): void
    {
        Auth::webRequireAdmin();
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Name is required';
            header("Location: /games/$gameId/achievements/create");
            exit;
        }
        if (R::findOne('achievement', 'game_id = ? AND name = ?', [$gameId, $data['name']])) {
            $_SESSION['error'] = 'Ce succès existe déjà pour ce jeu';
            header("Location: /games/$gameId/achievements/create");
            exit;
        }
        $achievement = R::dispense('achievement');
        $achievement->game_id = $gameId;
        $achievement->name = $data['name'];
        $achievement->description = $data['description'] ?? null;
        R::store($achievement);
        header("Location: /games/$gameId");
        exit;
    }

    public function webDestroy(int $id): void
    {
        Auth::webRequireAdmin();
        $achievement = R::load('achievement', $id);
        $gameId = $achievement->game_id ?? null;
        if ($achievement->id) {
            R::trash($achievement);
        }
        header($gameId ? "Location: /games/$gameId" : 'Location: /games');
        exit;
    }
}
