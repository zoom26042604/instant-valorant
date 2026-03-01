<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/rb-postgres.php';
require_once __DIR__ . '/../config/database.php';

session_start();

$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if (preg_match('#^/api(/|$)#', $uri)) {
    header('Content-Type: application/json');
    require_once __DIR__ . '/../src/Routes/api.php';
    exit;
}

require_once __DIR__ . '/../src/Routes/web.php';
