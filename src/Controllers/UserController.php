<?php

namespace App\Controllers;

use R;

class UserController
{
    public function index(): void
    {
        $users = R::findAll('user');
        echo json_encode(R::exportAll($users));
    }

    public function store(array $data): void
    {
        $user = R::dispense('user');
        $user->name = $data['name'] ?? null;
        $user->email = $data['email'] ?? null;
        $id = R::store($user);
        echo json_encode(['id' => $id]);
    }
}
