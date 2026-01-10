<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{
    public function login(): void
    {
        echo 'Login';
    }

    public function register(): void
    {
        echo 'Register';
    }
}