<?php

namespace App\Controllers;

use R;
use App\Helpers\Auth;

class AdminController
{
    public function users(): void
    {
        Auth::requireAdmin();
        $users = R::findAll('user');
        $data = array_map(fn($u) => [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'role' => $u->role,
        ], $users);
        echo json_encode($data);
    }

    public function updateUser(int $id, array $data): void
    {
        Auth::requireAdmin();
        $user = R::load('user', $id);
        if (!$user->id) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }
        if (isset($data['role']) && in_array($data['role'], ['user', 'admin'])) {
            $user->role = $data['role'];
        }
        R::store($user);
        echo json_encode(['message' => 'User updated']);
    }

    public function deleteUser(int $id): void
    {
        Auth::requireAdmin();
        $user = R::load('user', $id);
        if (!$user->id) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }
        R::trash($user);
        echo json_encode(['message' => 'User deleted']);
    }

    public function webUpdateUser(int $id, array $data): void
    {
        Auth::webRequireAdmin();
        $user = R::load('user', $id);
        if ($user->id && isset($data['role']) && in_array($data['role'], ['user', 'admin'])) {
            $user->role = $data['role'];
            R::store($user);
        }
        header('Location: /admin/users');
        exit;
    }

    public function webDeleteUser(int $id, array $data = []): void
    {
        Auth::webRequireAdmin();
        if ((int)$id === (int)$_SESSION['user_id']) {
            header('Location: /admin/users');
            exit;
        }
        $user = R::load('user', $id);
        if ($user->id) {
            R::trash($user);
        }
        header('Location: /admin/users');
        exit;
    }
}
