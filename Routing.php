<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';

// TODO Controller -> singleton
// URL: /dashboard/5432
// URL: /dashboard...              REGEX

class Routing {

    // jedyna instancja (singleton)
    private static ?Routing $instance = null;

    // tu trzymamy instancje kontrolerów
    private array $controllers = [];


    // trasy z regexem (więc zmieniona tablica na nową, inną)
    //rozbudowywanie za pomocą dodawania kolejnych routingow
    private array $routes = [
    [
        'pattern' => '#^login$#',
        'controller' => 'SecurityController',
        'action' => 'login'
    ],
    [
        'pattern' => '#^register$#',
        'controller' => 'SecurityController',
        'action' => 'register'
    ],
    [
        'pattern' => '#^dashboard(?:/(\d+))?$#',
        'controller' => 'DashboardController',
        'action' => 'index'
    ],
];


    //prywatne, aby nie mozna bylo utworzyc z zewnątrz
    private function __construct() {}
    private function __clone() {}


    //pobieranie singletona
    public static function getInstance(): Routing
    {
        if (self::$instance === null) {
            self::$instance = new Routing();
        }
        return self::$instance;
    }

    //ladowanie kontrolera tylko raz
    private function getController(string $name)
    {
        if (!isset($this->controllers[$name])) {
            $this->controllers[$name] = new $name();
        }
        return $this->controllers[$name];
    }

    //zmienione na tablice array, bo było na switchu
    //Router uruchamia kontroler + action
    public static function run(string $path): void
    {

        $router = self::getInstance();

        $path = trim($path, '/');

        foreach ($router->routes as $route) {

            if (preg_match($route['pattern'], $path, $matches)) {

                // pełne dopasowanie OUT
                array_shift($matches);

                $controller = $router->getController($route['controller']);
                $action = $route['action'];

                // wywołanie z parametrami
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }

        include 'public/views/404.html';
    }
}