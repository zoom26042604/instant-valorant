<?php

use App\Controllers\AuthController;
use App\Controllers\GameController;
use App\Controllers\LevelController;
use App\Controllers\AchievementController;
use App\Controllers\ProfileController;
use App\Controllers\UserGameController;
use App\Controllers\AdminController;
use App\Helpers\Auth;

$auth = new AuthController();

// Favicon
if ($uri === '/favicon.ico') {
    header('Location: /assets/logo.webp', true, 301);
    exit;

// Auth
} elseif ($uri === '/' && $method === 'GET') {
    $featuredGames = R::findAll('game', 'ORDER BY id ASC LIMIT 5');
    require __DIR__ . '/../../views/layout/home.php';
} elseif ($uri === '/login' && $method === 'GET') {
    require __DIR__ . '/../../views/auth/login.php';
} elseif ($uri === '/login' && $method === 'POST') {
    $auth->webLogin($_POST);
} elseif ($uri === '/register' && $method === 'GET') {
    require __DIR__ . '/../../views/auth/register.php';
} elseif ($uri === '/register' && $method === 'POST') {
    $auth->webRegister($_POST);
} elseif ($uri === '/logout') {
    $auth->webLogout();
} elseif ($uri === '/dashboard') {
    Auth::webRequireAuth();
    require __DIR__ . '/../../views/auth/dashboard.php';

// Games
} elseif ($uri === '/games' && $method === 'GET') {
    $games = R::findAll('game');
    require __DIR__ . '/../../views/games/index.php';
} elseif ($uri === '/games/create' && $method === 'GET') {
    Auth::webRequireAdmin();
    require __DIR__ . '/../../views/games/create.php';
} elseif ($uri === '/games' && $method === 'POST') {
    (new GameController())->webStore($_POST);
} elseif (preg_match('#^/games/(\d+)$#', $uri, $m) && $method === 'GET') {
    $gameId = (int)$m[1];
    $game = R::load('game', $gameId);
    if (!$game->id) { http_response_code(404); echo '404 Not Found'; exit; }
    $levels = R::find('level', 'game_id = ?', [$gameId]);
    $achievements = R::find('achievement', 'game_id = ?', [$gameId]);
    $userHasGame = !empty($_SESSION['user_id'])
        && R::findOne('usergame', 'user_id = ? AND game_id = ?', [$_SESSION['user_id'], $gameId]);
    require __DIR__ . '/../../views/games/show.php';
} elseif (preg_match('#^/games/(\d+)/edit$#', $uri, $m) && $method === 'GET') {
    Auth::webRequireAdmin();
    $gameId = (int)$m[1];
    $game = R::load('game', $gameId);
    if (!$game->id) { http_response_code(404); echo '404 Not Found'; exit; }
    require __DIR__ . '/../../views/games/edit.php';
} elseif (preg_match('#^/games/(\d+)/update$#', $uri, $m) && $method === 'POST') {
    (new GameController())->webUpdate((int)$m[1], $_POST);
} elseif (preg_match('#^/games/(\d+)/delete$#', $uri, $m) && $method === 'POST') {
    (new GameController())->webDestroy((int)$m[1]);

// Levels - DISABLED

// Achievements
} elseif (preg_match('#^/games/(\d+)/achievements/create$#', $uri, $m) && $method === 'GET') {
    Auth::webRequireAdmin();
    $gameId = (int)$m[1];
    $game = R::load('game', $gameId);
    if (!$game->id) { http_response_code(404); echo '404 Not Found'; exit; }
    require __DIR__ . '/../../views/achievements/create.php';
} elseif (preg_match('#^/games/(\d+)/achievements$#', $uri, $m) && $method === 'POST') {
    (new AchievementController())->webStore((int)$m[1], $_POST);
} elseif (preg_match('#^/achievements/(\d+)/delete$#', $uri, $m) && $method === 'POST') {
    (new AchievementController())->webDestroy((int)$m[1]);

// Profile
} elseif ($uri === '/profile' && $method === 'GET') {
    Auth::webRequireAuth();
    $userId = $_SESSION['user_id'];
    $user = R::load('user', $userId);
    $userGames = R::find('usergame', 'user_id = ?', [$userId]);
    $gamesData = [];
    $totalPlaytime = 0;
    foreach ($userGames as $ug) {
        $entry = ['ug' => $ug, 'game' => null];
        if ($ug->game_id) {
            $entry['game'] = R::load('game', $ug->game_id);
        }
        $totalPlaytime += (int)($ug->playtime ?? 0);
        $gamesData[] = $entry;
    }
    $totalGames = count($gamesData);
    $rawAchievements = R::find('userachievement', 'user_id = ?', [$userId]);
    $totalAchievements = 0;
    foreach ($rawAchievements as $ua) {
        if (empty($ua->achievement_id)) continue;
        $a = R::load('achievement', (int)$ua->achievement_id);
        if ($a->id) $totalAchievements++;
    }
    require __DIR__ . '/../../views/profile/index.php';
} elseif ($uri === '/profile/agent' && $method === 'POST') {
    Auth::webRequireAuth();
    $userId = $_SESSION['user_id'];
    $user = R::load('user', $userId);
    $allowedAgents = ['astra','breach','brimstone','chamber','clove','cypher','deadlock','fade','gekko','harbor','iso','jett','kayo','killjoy','neon','omen','phoenix','raze','reyna','sage','skye','sova','tejo','veto','viper','vyse','waylay','yoru'];
    $agent = $_POST['agent'] ?? null;
    if ($agent && in_array($agent, $allowedAgents)) {
        $user->agent = $agent;
        R::store($user);
    }
    header('Location: /profile');
    exit;
} elseif ($uri === '/profile/games/add' && $method === 'GET') {
    Auth::webRequireAuth();
    $games = R::findAll('game');
    $preselected = $_GET['game_id'] ?? null;
    require __DIR__ . '/../../views/profile/add_game.php';
} elseif ($uri === '/profile/games' && $method === 'POST') {
    (new UserGameController())->webStore($_POST);
} elseif (preg_match('#^/profile/games/(\d+)/edit$#', $uri, $m) && $method === 'GET') {
    Auth::webRequireAuth();
    $userGame = R::load('usergame', (int)$m[1]);
    if (!$userGame->id || $userGame->user_id != $_SESSION['user_id']) {
        http_response_code(404); echo '404 Not Found'; exit;
    }
    require __DIR__ . '/../../views/profile/edit_game.php';
} elseif (preg_match('#^/profile/games/(\d+)/update$#', $uri, $m) && $method === 'POST') {
    (new UserGameController())->webUpdate((int)$m[1], $_POST);
} elseif (preg_match('#^/profile/games/(\d+)/delete$#', $uri, $m) && $method === 'POST') {
    (new UserGameController())->webDestroy((int)$m[1]);
} elseif ($uri === '/profile/achievements' && $method === 'GET') {
    Auth::webRequireAuth();
    $userId = $_SESSION['user_id'];
    $userAchievements = R::find('userachievement', 'user_id = ?', [$userId]);
    $achievementsData = [];
    foreach ($userAchievements as $ua) {
        if (empty($ua->achievement_id)) continue;
        $a = R::load('achievement', (int)$ua->achievement_id);
        if (!$a->id) continue;
        $game = $a->game_id ? R::load('game', (int)$a->game_id) : null;
        $achievementsData[] = ['ua' => $ua, 'achievement' => $a, 'game' => ($game && $game->id) ? $game : null];
    }
    require __DIR__ . '/../../views/profile/achievements.php';
} elseif (preg_match('#^/profile/achievements/(\d+)/unlock$#', $uri, $m) && $method === 'POST') {
    (new ProfileController())->webUnlockAchievement((int)$m[1]);

// Admin
} elseif ($uri === '/admin' && $method === 'GET') {
    Auth::webRequireAdmin();
    require __DIR__ . '/../../views/admin/index.php';
} elseif ($uri === '/admin/games' && $method === 'GET') {
    Auth::webRequireAdmin();
    $games = R::findAll('game');
    require __DIR__ . '/../../views/admin/games.php';
} elseif ($uri === '/admin/users' && $method === 'GET') {
    Auth::webRequireAdmin();
    $users = R::findAll('user');
    require __DIR__ . '/../../views/admin/users.php';
} elseif (preg_match('#^/admin/users/(\d+)/role$#', $uri, $m) && $method === 'POST') {
    (new AdminController())->webUpdateUser((int)$m[1], $_POST);
} elseif (preg_match('#^/admin/users/(\d+)/delete$#', $uri, $m) && $method === 'POST') {
    (new AdminController())->webDeleteUser((int)$m[1]);

} else {
    http_response_code(404);
    echo '404 Not Found';
}
