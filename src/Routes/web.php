<?php

use App\Controllers\AuthController;

$auth = new AuthController();

match (true) {
    $uri === '/' => require __DIR__ . '/../../views/layout/home.php',

    $uri === '/login' && $method === 'GET' => require __DIR__ . '/../../views/auth/login.php',
    $uri === '/login' && $method === 'POST' => $auth->webLogin($_POST),

    $uri === '/register' && $method === 'GET' => require __DIR__ . '/../../views/auth/register.php',
    $uri === '/register' && $method === 'POST' => $auth->webRegister($_POST),

    $uri === '/logout' => $auth->webLogout(),

    $uri === '/dashboard' => (function () {
            if (empty($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }
            require __DIR__ . '/../../views/auth/dashboard.php';
        })(),

    default => (function () {
            http_response_code(404);
            echo '404 Not Found';
        })(),
};
