<?php

namespace App\Middleware;

use App\Services\SessionService;

class AdminMiddleware
{
    public static function handle(): void
    {
        if (!SessionService::isAdmin()) {
            http_response_code(403);
            require __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }
}