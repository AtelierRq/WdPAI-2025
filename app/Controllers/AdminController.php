<?php

namespace App\Controllers;

use App\Core\Controller;

class AdminController extends Controller
{
    public function dashboard(): void
    {
        echo 'Panel administratora';
    }

    public function pending(): void
    {
        $this->view('admin/pending');
    }

    public function approved(): void
    {
    $this->view('admin/approved');
    }
}