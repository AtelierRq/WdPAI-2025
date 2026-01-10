<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, array $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, array $action): void
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        if (!isset($this->routes[$method][$uri])) {
            $this->abort(404);
            return;
        }

        [$controller, $methodName] = $this->routes[$method][$uri];

        $controllerInstance = new $controller();
        $controllerInstance->$methodName();
    }

    private function abort(int $code): void
    {
        http_response_code($code);
        require __DIR__ . '/../Views/errors/404.php';
        exit;
    }
}