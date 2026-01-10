<?php

namespace App\Controllers;

use App\Core\Controller;

class AdminController extends Controller
{
    public function dashboard(): void
    {
        echo 'Panel administratora';
    }
}