<?php

use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Controllers\GameController;
use App\Controllers\LevelController;
use App\Controllers\AchievementController;
use App\Controllers\ProfileController;
use App\Controllers\UserGameController;
use App\Controllers\AdminController;

$segments = explode('/', trim($uri, '/'));
$r1 = $segments[1] ?? '';
$r2 = $segments[2] ?? '';
$r3 = $segments[3] ?? '';
$r4 = $segments[4] ?? '';

$body = json_decode(file_get_contents('php://input'), true) ?? [];

// Auth
if ($r1 === 'auth') {
    $auth = new AuthController();
    match (true) {
        $r2 === 'register' && $method === 'POST' => $auth->register($body),
        $r2 === 'login' && $method === 'POST' => $auth->login($body),
        $r2 === 'logout' && $method === 'POST' => $auth->logout(),
        default => (function () {
                http_response_code(404);
                echo json_encode(['error' => 'Not found']);
            })(),
    };
    exit;
}

// Games
if ($r1 === 'games') {
    $gc = new GameController();

    if ($r2 === '' && $method === 'GET') {
        $gc->index();
        exit;
    }
    if ($r2 === '' && $method === 'POST') {
        $gc->store($body);
        exit;
    }
    if ($r2 === 'seed' && $method === 'POST') {
        $gc->seed();
        exit;
    }

    if (is_numeric($r2)) {
        $gameId = (int) $r2;

        if ($r3 === '' && $method === 'GET') {
            $gc->show($gameId);
            exit;
        }
        if ($r3 === '' && $method === 'PUT') {
            $gc->update($gameId, $body);
            exit;
        }
        if ($r3 === '' && $method === 'DELETE') {
            $gc->destroy($gameId);
            exit;
        }

        if ($r3 === 'levels') {
            $lc = new LevelController();
            if ($method === 'GET') {
                $lc->index($gameId);
                exit;
            }
            if ($method === 'POST') {
                $lc->store($gameId, $body);
                exit;
            }
        }

        if ($r3 === 'achievements') {
            $ac = new AchievementController();
            if ($method === 'GET') {
                $ac->index($gameId);
                exit;
            }
            if ($method === 'POST') {
                $ac->store($gameId, $body);
                exit;
            }
        }
    }
}

// Levels
if ($r1 === 'levels' && is_numeric($r2)) {
    $lc = new LevelController();
    $id = (int) $r2;
    if ($method === 'PUT') {
        $lc->update($id, $body);
        exit;
    }
    if ($method === 'DELETE') {
        $lc->destroy($id);
        exit;
    }
}

// Achievements
if ($r1 === 'achievements' && is_numeric($r2)) {
    $ac = new AchievementController();
    $id = (int) $r2;
    if ($method === 'DELETE') {
        $ac->destroy($id);
        exit;
    }
}

// Profile
if ($r1 === 'profile') {
    if ($r2 === '' && $method === 'GET') {
        (new ProfileController())->show();
        exit;
    }

    if ($r2 === 'games') {
        $ugc = new UserGameController();
        if ($r3 === '' && $method === 'GET') {
            $ugc->index();
            exit;
        }
        if ($r3 === '' && $method === 'POST') {
            $ugc->store($body);
            exit;
        }
        if (is_numeric($r3)) {
            $id = (int) $r3;
            if ($method === 'PUT') {
                $ugc->update($id, $body);
                exit;
            }
            if ($method === 'DELETE') {
                $ugc->destroy($id);
                exit;
            }
        }
    }

    if ($r2 === 'achievements') {
        $pc = new ProfileController();
        if ($r3 === '' && $method === 'GET') {
            $pc->achievements();
            exit;
        }
        if (is_numeric($r3) && $method === 'POST') {
            $pc->unlockAchievement((int) $r3);
            exit;
        }
    }
}

// Users (legacy)
if ($r1 === 'users') {
    $controller = new UserController();
    match ($method) {
        'GET' => $controller->index(),
        'POST' => $controller->store($body),
        default => http_response_code(405),
    };
    exit;
}

// Admin
if ($r1 === 'admin') {
    $admin = new AdminController();
    if ($r2 === 'users') {
        if ($r3 === '' && $method === 'GET') {
            $admin->users();
            exit;
        }
        if (is_numeric($r3)) {
            $id = (int) $r3;
            if ($method === 'PUT') {
                $admin->updateUser($id, $body);
                exit;
            }
            if ($method === 'DELETE') {
                $admin->deleteUser($id);
                exit;
            }
        }
    }
}

http_response_code(404);
echo json_encode(['error' => 'Route not found']);
