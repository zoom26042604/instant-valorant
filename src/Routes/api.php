<?php

use App\Controllers\UserController;

$controller = new UserController();
$method = $_SERVER['REQUEST_METHOD'];

match ($method) {
    'GET'  => $controller->index(),
    'POST' => $controller->store(json_decode(file_get_contents('php://input'), true) ?? []),
    default => http_response_code(405),
};
