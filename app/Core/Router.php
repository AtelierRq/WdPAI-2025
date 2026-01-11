<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, callable|array $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, callable|array $action): void
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

        $action = $this->routes[$method][$uri];

        // Closure
        if (is_callable($action)) {
            $action();
            return;
        }

        // [Controller::class, 'method']
        [$controller, $methodName] = $action;

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