<?php

namespace App\Services;
use App\Database\Database;

class AuthService
{
    public static function attempt(string $email, string $password): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT * FROM users WHERE email = :email LIMIT 1"
        );
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }

        $_SESSION['user'] = [
            'id'    => $user['id'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ];

        return true;
    }
}