<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';

// TODO Controller -> singleton
// URL: /dashboard/5432
// URL: /dashboard...              REGEX

class Routing {

    //rozbudowywanie za pomocą dodwania kolejnych routingow
    public static $routes = [
        "login" => [
            "controller" => "SecurityController",
            "action" => "login",
        ],
        "register" => [
            "controller" => "SecurityController",
            "action" => "register",
        ],
        "dashboard" => [
            "controller"=> "DashboardController",
            "action" => "index",
        ]
        ];
    public static function run(string $path) {


        switch ($path) {
            case 'login':
            // include 'public/views/login.html';
            case 'register':
            case 'dashboard':
                $controller = self::$routes[$path]['controller'];
                $action = self::$routes[$path]['action'];
                $id = $urlParts[1] ?? '';

                $controllerObj = new $controller();
                $controllerObj ->$action();
                break;
            default:
                include 'public/views/404.html';
                break;
        }
    }
}