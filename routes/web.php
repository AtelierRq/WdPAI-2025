<?php

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Controllers\BookingController;

/** @var Router $this */

$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'register']);
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/booking', [BookingController::class, 'form']);
$router->get('/booking/success', [BookingController::class, 'success']);
$router->get('/admin/pending', [AdminController::class, 'pending']);

