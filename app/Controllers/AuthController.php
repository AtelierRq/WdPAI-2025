<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{
    
    public function login(): void
    {
    $this->view('auth/login');
    }

    public function register(): void
    {
    $this->view('auth/register');
    }
    

}