<?php

namespace App\Middleware;

use App\Services\SessionService;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!SessionService::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }
}