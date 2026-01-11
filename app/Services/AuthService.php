<?php

namespace App\Services;

class AuthService
{
    public static function attempt(string $email, string $password): bool
    {
        $users = require __DIR__ . '/../../config/auth.php';

        foreach ($users as $user) {
            if (
                $user['email'] === $email &&
                $user['password'] === $password
            ) {
                SessionService::login($user);
                return true;
            }
        }

        return false;
    }
}