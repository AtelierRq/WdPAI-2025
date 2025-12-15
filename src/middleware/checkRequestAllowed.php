<?php

require_once __DIR__ . '/../attribute/AllowedMethods.php';

function checkRequestAllowed(object $controller, string $methodName): void
{
    $reflection = new ReflectionMethod($controller, $methodName);
    $attributes = $reflection->getAttributes(AllowedMethods::class);

    // jeśli metoda NIE ma adnotacji → nic nie blokujemy
    if (empty($attributes)) {
        return;
    }

    /** @var AllowedMethods $instance */
    $instance = $attributes[0]->newInstance();
    $allowedMethods = $instance->methods;

    if (!in_array($_SERVER['REQUEST_METHOD'], $allowedMethods)) {
        http_response_code(405);
        include 'public/views/404.html'; // albo osobna strona 405
        exit;
    }
}