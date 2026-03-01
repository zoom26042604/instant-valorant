<?php

namespace App\Controllers;

use R;
use App\Helpers\Auth;

class LevelController
{
    public function index(int $gameId): void
    {
        $levels = R::find('level', 'game_id = ?', [$gameId]);
        echo json_encode(R::exportAll($levels));
    }

    public function store(int $gameId, array $data): void
    {
        Auth::requireAdmin();
        if (empty($data['name'])) {
            http_response_code(422);
            echo json_encode(['error' => 'Name is required']);
            return;
        }
        $level = R::dispense('level');
        $level->game_id = $gameId;
        $level->name = $data['name'];
        $level->description = $data['description'] ?? null;
        $id = R::store($level);
        http_response_code(201);
        echo json_encode(['id' => $id, 'message' => 'Level created']);
    }

    public function update(int $id, array $data): void
    {
        Auth::requireAdmin();
        $level = R::load('level', $id);
        if (!$level->id) {
            http_response_code(404);
            echo json_encode(['error' => 'Level not found']);
            return;
        }
        if (isset($data['name'])) $level->name = $data['name'];
        if (isset($data['description'])) $level->description = $data['description'];
        R::store($level);
        echo json_encode(['message' => 'Level updated']);
    }

    public function destroy(int $id): void
    {
        Auth::requireAdmin();
        $level = R::load('level', $id);
        if (!$level->id) {
            http_response_code(404);
            echo json_encode(['error' => 'Level not found']);
            return;
        }
        R::trash($level);
        echo json_encode(['message' => 'Level deleted']);
    }

    public function webStore(int $gameId, array $data): void
    {
        Auth::webRequireAdmin();
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Name is required';
            header("Location: /games/$gameId/levels/create");
            exit;
        }
        $level = R::dispense('level');
        $level->game_id = $gameId;
        $level->name = $data['name'];
        $level->description = $data['description'] ?? null;
        R::store($level);
        header("Location: /games/$gameId");
        exit;
    }

    public function webUpdate(int $id, array $data): void
    {
        Auth::webRequireAdmin();
        $level = R::load('level', $id);
        if (!$level->id) {
            http_response_code(404);
            echo '404 Not Found';
            exit;
        }
        $gameId = $level->game_id;
        if (isset($data['name'])) $level->name = $data['name'];
        if (isset($data['description'])) $level->description = $data['description'];
        R::store($level);
        header("Location: /games/$gameId");
        exit;
    }

    public function webDestroy(int $id): void
    {
        Auth::webRequireAdmin();
        $level = R::load('level', $id);
        $gameId = $level->game_id ?? null;
        if ($level->id) {
            R::trash($level);
        }
        header($gameId ? "Location: /games/$gameId" : 'Location: /games');
        exit;
    }
}
