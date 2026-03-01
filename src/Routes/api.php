<?php

use App\Controllers\UserController;
use App\Controllers\AuthController;

$segments = explode('/', trim($uri, '/'));
$resource = $segments[1] ?? '';
$action = $segments[2] ?? '';

if ($resource === 'auth') {
    $auth = new AuthController();
    $body = json_decode(file_get_contents('php://input'), true) ?? [];

    match (true) {
        $action === 'register' && $method === 'POST' => $auth->register($body),
        $action === 'login' && $method === 'POST' => $auth->login($body),
        $action === 'logout' && $method === 'POST' => $auth->logout(),
        default => (function () {
                http_response_code(404);
                echo json_encode(['error' => 'Not found']); })(),
    };
    exit;
}

if ($resource === 'users') {
    $controller = new UserController();
    match ($method) {
        'GET' => $controller->index(),
        'POST' => $controller->store(json_decode(file_get_contents('php://input'), true) ?? []),
        default => http_response_code(405),
    };
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Route not found']);
