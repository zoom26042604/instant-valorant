<?php

namespace App\Controllers;

class AuthController
{
    public function register(array $data): void
    {
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            http_response_code(422);
            echo json_encode(['error' => 'Name, email and password are required']);
            return;
        }

        if (R::findOne('user', 'email = ?', [$data['email']])) {
            http_response_code(409);
            echo json_encode(['error' => 'Email already in use']);
            return;
        }

        $user = R::dispense('user');
        $user->name     = $data['name'];
        $user->email    = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_ARGON2ID);
        R::store($user);

        http_response_code(201);
        echo json_encode(['message' => 'Account created']);
    }

    public function login(array $data): void
    {
        if (empty($data['email']) || empty($data['password'])) {
            http_response_code(422);
            echo json_encode(['error' => 'Email and password are required']);
            return;
        }

        $user = R::findOne('user', 'email = ?', [$data['email']]);

        if (!$user || !password_verify($data['password'], $user->password)) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
            return;
        }

        session_regenerate_id(true);
        $_SESSION['user_id']    = $user->id;
        $_SESSION['user_name']  = $user->name;
        $_SESSION['user_email'] = $user->email;

        echo json_encode(['message' => 'Logged in', 'user' => ['id' => $user->id, 'name' => $user->name]]);
    }

    public function logout(): void
    {
        session_destroy();
        echo json_encode(['message' => 'Logged out']);
    }

    public function webRegister(array $data): void
    {
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            $_SESSION['error'] = 'All fields are required';
            header('Location: /register');
            exit;
        }

        if (R::findOne('user', 'email = ?', [$data['email']])) {
            $_SESSION['error'] = 'Email already in use';
            header('Location: /register');
            exit;
        }

        $user = R::dispense('user');
        $user->name     = $data['name'];
        $user->email    = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_ARGON2ID);
        R::store($user);

        session_regenerate_id(true);
        $_SESSION['user_id']    = $user->id;
        $_SESSION['user_name']  = $user->name;
        $_SESSION['user_email'] = $user->email;

        header('Location: /dashboard');
        exit;
    }

    public function webLogin(array $data): void
    {
        if (empty($data['email']) || empty($data['password'])) {
            $_SESSION['error'] = 'Email and password are required';
            header('Location: /login');
            exit;
        }

        $user = R::findOne('user', 'email = ?', [$data['email']]);

        if (!$user || !password_verify($data['password'], $user->password)) {
            $_SESSION['error'] = 'Invalid credentials';
            header('Location: /login');
            exit;
        }

        session_regenerate_id(true);
        $_SESSION['user_id']    = $user->id;
        $_SESSION['user_name']  = $user->name;
        $_SESSION['user_email'] = $user->email;

        header('Location: /dashboard');
        exit;
    }

    public function webLogout(): void
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
