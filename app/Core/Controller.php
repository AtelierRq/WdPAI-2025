<?php

namespace App\Core;

class Controller
{
    protected function view(string $path): void
    {
        require __DIR__ . '/../Views/' . $path . '.php';
    }
}