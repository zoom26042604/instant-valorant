<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/rb-postgres.php';
require_once __DIR__ . '/../config/database.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('#^/api(/|$)#', $uri)) {
    header('Content-Type: application/json');
    require_once __DIR__ . '/../src/Routes/api.php';
    exit;
}

if ($uri === '/' || $uri === '/index.php') {
    require_once __DIR__ . '/../views/layout/home.php';
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Not found']);
