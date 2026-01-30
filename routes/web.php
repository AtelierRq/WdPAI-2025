<?php

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Controllers\BookingController;
use App\Controllers\AdminBookingController;

use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;

/** @var Router $this */

$router->get('/', [HomeController::class, 'index']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);

$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'store']);

$router->get('/booking', [BookingController::class, 'form']);
$router->get('/booking/success', [BookingController::class, 'success']);
$router->post('/booking', [BookingController::class, 'store']);

$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/pending', [AdminController::class, 'pending']);
$router->get('/admin/approved', [AdminController::class, 'approved']);


$router->get('/admin/pending', function () {
    AuthMiddleware::handle();
    AdminMiddleware::handle();
    (new App\Controllers\AdminController())->pending();
});

$router->get('/admin/approved', function () {
    AuthMiddleware::handle();
    AdminMiddleware::handle();
    (new App\Controllers\AdminController())->approved();
});


// --- ADMIN: LISTY REZERWACJI ---
$router->get('/admin/bookings/pending', [AdminBookingController::class, 'pending']);
$router->get('/admin/bookings/accepted', [AdminBookingController::class, 'accepted']);
$router->get('/admin/bookings/rejected', [AdminBookingController::class, 'rejected']);

// --- ADMIN: AKCJE ---
$router->post('/admin/bookings/accept', [AdminBookingController::class, 'accept']);
$router->post('/admin/bookings/reject', [AdminBookingController::class, 'reject']);