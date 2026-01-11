<?php

namespace App\Core;

// automatyczne załadowywanie ścieżek, żeby nie używać ciągla require_once __DIR__
class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register(function (string $class) {
            $prefix = 'App\\';
            $baseDir = __DIR__ . '/../';

            if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
                return;
            }

            $relativeClass = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
}