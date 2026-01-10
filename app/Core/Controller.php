<?php

namespace App\Core;

class Controller
{
    //każdy widok dostaje header + footer oraz może przyjmować dane $data
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/' . $view . '.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }
}