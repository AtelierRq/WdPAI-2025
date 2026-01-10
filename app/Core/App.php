<?php

namespace App\Core;

class App
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->loadRoutes();
    }

    private function loadRoutes(): void
    {
        $router = $this->router;
        require_once __DIR__ . '/../../routes/web.php';
    }

    public function run(): void
    {
        $this->router->dispatch(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD']
        );
    }
}