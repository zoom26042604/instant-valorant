<?php

namespace App\Controllers;

use R;
use App\Helpers\Auth;

class ProfileController
{
    public function show(): void
    {
        Auth::requireAuth();
        $userId = $_SESSION['user_id'];
        $user = R::load('user', $userId);

        $userGames = R::find('usergame', 'user_id = ?', [$userId]);
        $gamesData = [];
        foreach ($userGames as $ug) {
            $entry = $ug->export();
            if ($ug->game_id) {
                $entry['game'] = R::load('game', $ug->game_id)->export();
            }
            $gamesData[] = $entry;
        }

        echo json_encode([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'games' => $gamesData,
        ]);
    }

    public function achievements(): void
    {
        Auth::requireAuth();
        $userId = $_SESSION['user_id'];
        $userAchievements = R::find('userachievement', 'user_id = ?', [$userId]);

        $data = [];
        foreach ($userAchievements as $ua) {
            $entry = $ua->export();
            $achievement = R::load('achievement', $ua->achievement_id);
            $entry['achievement'] = $achievement->export();
            $data[] = $entry;
        }

        echo json_encode($data);
    }

    public function unlockAchievement(int $achievementId): void
    {
        Auth::requireAuth();
        $userId = $_SESSION['user_id'];

        $achievement = R::load('achievement', $achievementId);
        if (!$achievement->id) {
            http_response_code(404);
            echo json_encode(['error' => 'Achievement not found']);
            return;
        }

        if (R::findOne('userachievement', 'user_id = ? AND achievement_id = ?', [$userId, $achievementId])) {
            http_response_code(409);
            echo json_encode(['error' => 'Achievement already unlocked']);
            return;
        }

        $ua = R::dispense('userachievement');
        $ua->user_id = $userId;
        $ua->achievement_id = $achievementId;
        $ua->unlocked_at = date('Y-m-d H:i:s');
        R::store($ua);

        echo json_encode(['message' => 'Achievement unlocked']);
    }

    public function webUnlockAchievement(int $achievementId): void
    {
        Auth::webRequireAuth();
        $userId = $_SESSION['user_id'];

        $achievement = R::load('achievement', $achievementId);
        if (!$achievement->id) {
            http_response_code(404);
            echo '404 Not Found';
            exit;
        }

        if (!R::findOne('userachievement', 'user_id = ? AND achievement_id = ?', [$userId, $achievementId])) {
            $ua = R::dispense('userachievement');
            $ua->user_id = $userId;
            $ua->achievement_id = $achievementId;
            $ua->unlocked_at = date('Y-m-d H:i:s');
            R::store($ua);
        }

        $gameId = $achievement->game_id;
        header("Location: /games/$gameId");
        exit;
    }
}
