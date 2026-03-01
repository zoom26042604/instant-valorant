<?php

namespace App\Helpers;

class Auth
{
    public static function check(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public static function isAdmin(): bool
    {
        return !empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public static function requireAuth(): void
    {
        if (!self::check()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::requireAuth();
        if (!self::isAdmin()) {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }
    }

    public static function webRequireAuth(): void
    {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }

    public static function webRequireAdmin(): void
    {
        self::webRequireAuth();
        if (!self::isAdmin()) {
            http_response_code(403);
            echo '403 Forbidden';
            exit;
        }
    }
}
