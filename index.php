<?php
// Simple PHP router for demonstration
if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php') {
    include __DIR__ . '/public/login.html';
    exit;
}
// Add more routes as needed
http_response_code(404);
echo '404 Not Found';