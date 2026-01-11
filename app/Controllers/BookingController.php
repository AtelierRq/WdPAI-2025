<?php

namespace App\Controllers;

use App\Core\Controller;

class BookingController extends Controller
{
    public function form(): void
    {
        $this->view('booking/form');
    }
}