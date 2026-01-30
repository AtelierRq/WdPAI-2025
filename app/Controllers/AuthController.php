<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Services\SessionService;
use App\Database\Database;
use PDO;

class AuthController extends Controller
{
    public function login(): void
    {
        if (!empty($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!$email || !$password) {
                $this->view('auth/login', [
                    'error' => 'Uzupełnij email i hasło'
                ]);
                return;
            }

            $success = AuthService::attempt(
                email: $email,
                password: $password
            );

            if ($success) {
                header('Location: /');
                exit;
            }

            $this->view('auth/login', [
                'error' => 'Nieprawidłowe dane logowania'
            ]);
            return;
        }

        $this->view('auth/login');
    }

    public function logout(): void
    {
        SessionService::logout();
        header('Location: /');
        exit;
    }

    public function register(): void
    {
        $this->view('auth/register');
    }

    public function store(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$name || !$email || !$password) {
            http_response_code(400);
            echo 'Nieprawidłowe dane';
            return;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $db = Database::getConnection();

        $stmt = $db->prepare("
            INSERT INTO users (email, password_hash, role)
            VALUES (:email, :password, 'user')
        ");

        try {
            $stmt->execute([
                'email' => $email,
                'password' => $hash,
            ]);
        } catch (\PDOException $e) {
            http_response_code(400);
            echo 'Email już istnieje';
            return;
        }

        // auto-login po rejestracji
        $_SESSION['user'] = [
            'email' => $email,
            'role' => 'user'
        ];

        header('Location: /');
        exit;
    }
}