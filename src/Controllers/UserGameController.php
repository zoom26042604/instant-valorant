<?php

namespace App\Controllers;

use R;
use App\Helpers\Auth;

class UserGameController
{
    public function index(): void
    {
        Auth::requireAuth();
        $userId = $_SESSION['user_id'];
        $userGames = R::find('usergame', 'user_id = ?', [$userId]);
        echo json_encode(R::exportAll($userGames));
    }

    public function store(array $data): void
    {
        Auth::requireAuth();
        $userId = $_SESSION['user_id'];

        $ug = R::dispense('usergame');
        $ug->user_id = $userId;
        $ug->date_added = date('Y-m-d', rand(strtotime('2020-01-01'), strtotime('2024-12-31')));
        $ug->playtime = rand(1, 5000);

        if (!empty($data['game_id'])) {
            $game = R::load('game', (int)$data['game_id']);
            if (!$game->id) {
                http_response_code(404);
                echo json_encode(['error' => 'Game not found']);
                return;
            }
            if (R::findOne('usergame', 'user_id = ? AND game_id = ?', [$userId, $game->id])) {
                http_response_code(409);
                echo json_encode(['error' => 'Game already in library']);
                return;
            }
            $ug->game_id = $game->id;
        } else {
            if (empty($data['custom_name'])) {
                http_response_code(422);
                echo json_encode(['error' => 'game_id or custom_name is required']);
                return;
            }
            $ug->game_id = null;
            $ug->custom_name = $data['custom_name'];
            $ug->custom_type = $data['custom_type'] ?? null;
            $ug->custom_description = $data['custom_description'] ?? null;
            $ug->custom_image_url = $data['custom_image_url'] ?? null;
        }

        $id = R::store($ug);

        if (!empty($ug->game_id)) {
            $this->autoUnlockDebutant($userId, $ug->game_id);
        }

        http_response_code(201);
        echo json_encode(['id' => $id, 'message' => 'Game added to library']);
    }

    public function update(int $id, array $data): void
    {
        Auth::requireAuth();
        $userId = $_SESSION['user_id'];
        $ug = R::load('usergame', $id);

        if (!$ug->id || $ug->user_id != $userId) {
            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
            return;
        }

        if (isset($data['custom_name'])) $ug->custom_name = $data['custom_name'];
        if (isset($data['custom_type'])) $ug->custom_type = $data['custom_type'];
        if (isset($data['custom_description'])) $ug->custom_description = $data['custom_description'];
        if (isset($data['custom_image_url'])) $ug->custom_image_url = $data['custom_image_url'];

        R::store($ug);
        echo json_encode(['message' => 'Library entry updated']);
    }

    public function destroy(int $id): void
    {
        Auth::requireAuth();
        $userId = $_SESSION['user_id'];
        $ug = R::load('usergame', $id);

        if (!$ug->id || $ug->user_id != $userId) {
            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
            return;
        }

        if ($ug->game_id) {
            R::exec(
                'DELETE FROM userachievement WHERE user_id = ? AND achievement_id IN (SELECT id FROM achievement WHERE game_id = ?)',
                [$userId, $ug->game_id]
            );
        }

        R::trash($ug);
        echo json_encode(['message' => 'Game removed from library']);
    }

    public function webStore(array $data): void
    {
        Auth::webRequireAuth();
        $userId = $_SESSION['user_id'];
        $errorRedirect = !empty($data['_from']) ? $data['_from'] : '/profile/games/add';

        $ug = R::dispense('usergame');
        $ug->user_id = $userId;
        $ug->date_added = date('Y-m-d', rand(strtotime('2020-01-01'), strtotime('2024-12-31')));
        $ug->playtime = rand(1, 5000);

        if (!empty($data['game_id'])) {
            $game = R::load('game', (int)$data['game_id']);
            if (!$game->id) {
                $_SESSION['error'] = 'Jeu introuvable';
                header('Location: ' . $errorRedirect);
                exit;
            }
            if (R::findOne('usergame', 'user_id = ? AND game_id = ?', [$userId, $game->id])) {
                $_SESSION['error'] = 'Ce jeu est déjà dans votre bibliothèque';
                header('Location: ' . $errorRedirect);
                exit;
            }
            $ug->game_id = $game->id;
        } else {
            if (empty($data['custom_name'])) {
                $_SESSION['error'] = 'Le nom est obligatoire';
                header('Location: ' . $errorRedirect);
                exit;
            }
            $ug->game_id = null;
            $ug->custom_name = $data['custom_name'];
            $ug->custom_type = $data['custom_type'] ?? null;
            $ug->custom_description = $data['custom_description'] ?? null;
            $ug->custom_image_url = $data['custom_image_url'] ?? null;
        }

        R::store($ug);

        if (!empty($ug->game_id)) {
            $this->autoUnlockDebutant($userId, $ug->game_id);
            $_SESSION['success'] = 'Jeu ajouté à votre bibliothèque !';
            header('Location: /games/' . $ug->game_id);
        } else {
            $_SESSION['success'] = 'Jeu personnalisé ajouté à votre bibliothèque !';
            header('Location: /profile');
        }
        exit;
    }

    public function webUpdate(int $id, array $data): void
    {
        Auth::webRequireAuth();
        $userId = $_SESSION['user_id'];
        $ug = R::load('usergame', $id);

        if (!$ug->id || $ug->user_id != $userId) {
            http_response_code(404);
            echo '404 Not Found';
            exit;
        }

        if (isset($data['custom_name'])) $ug->custom_name = $data['custom_name'];
        if (isset($data['custom_type'])) $ug->custom_type = $data['custom_type'];
        if (isset($data['custom_description'])) $ug->custom_description = $data['custom_description'];
        if (isset($data['custom_image_url'])) $ug->custom_image_url = $data['custom_image_url'];

        R::store($ug);
        header('Location: /profile');
        exit;
    }

    public function webDestroy(int $id): void
    {
        Auth::webRequireAuth();
        $userId = $_SESSION['user_id'];
        $ug = R::load('usergame', $id);

        if ($ug->id && $ug->user_id == $userId) {
            $gameId = $ug->game_id;
            if ($ug->game_id) {
                R::exec(
                    'DELETE FROM userachievement WHERE user_id = ? AND achievement_id IN (SELECT id FROM achievement WHERE game_id = ?)',
                    [$userId, $ug->game_id]
                );
            }
            R::trash($ug);
            $_SESSION['success'] = 'Jeu supprimé de votre bibliothèque';
            $redirect = !empty($_POST['_redirect']) ? $_POST['_redirect'] : ($gameId ? '/games/' . $gameId : '/profile');
            header('Location: ' . $redirect);
        } else {
            header('Location: /profile');
        }
        exit;
    }

    private function autoUnlockDebutant(int $userId, int $gameId): void
    {
        $achievement = R::findOne('achievement', 'game_id = ? AND name = ?', [$gameId, 'Débutant']);
        if (!$achievement) {
            return;
        }
        if (R::findOne('userachievement', 'user_id = ? AND achievement_id = ?', [$userId, $achievement->id])) {
            return;
        }
        $ua = R::dispense('userachievement');
        $ua->user_id = $userId;
        $ua->achievement_id = $achievement->id;
        $ua->unlocked_at = date('Y-m-d H:i:s');
        R::store($ua);
    }
}
