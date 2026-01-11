<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Services\SessionService;

class AuthController extends Controller
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = AuthService::attempt(
                $_POST['email'] ?? '',
                $_POST['password'] ?? ''
            );

            if ($success) {
                header('Location: /');
                exit;
            }

            $this->view('auth/login', ['error' => 'Nieprawidłowe dane logowania']);
            return;
        }

        $this->view('auth/login');
    }

    public function logout(): void
    {
        SessionService::logout();
        header('Location: /login');
        exit;
    }

    public function register(): void
    {
    $this->view('auth/register');
    }
}