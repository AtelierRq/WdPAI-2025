<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\BookingRepository;

class BookingController extends Controller
{
    public function form(): void
    {
        $this->view('booking/form');
    }

    public function success(): void
    {
    $this->view('booking/success');
    }

    public function store(): void
    {
        $data = [
            'user_id'  => null, // na razie gość
            'fullName' => trim($_POST['fullName'] ?? ''),
            'email'    => trim($_POST['email'] ?? ''),
            'phone'    => trim($_POST['phone'] ?? ''),
            'dateFrom' => $_POST['dateFrom'] ?? '',
            'dateTo'   => $_POST['dateTo'] ?? '',
            'adults'   => (int) ($_POST['adults'] ?? 0),
            'children' => (int) ($_POST['children'] ?? 0),
            'infants'  => (int) ($_POST['infants'] ?? 0),
            'rooms'    => array_map('intval', explode(',', $_POST['rooms'] ?? '')),
            'breakfast' => isset($_POST['breakfast']) ? 1 : 0,
            'notes'    => trim($_POST['notes'] ?? ''),
            'price'    => (int) ($_POST['price'] ?? 0),
        ];

        if (
            !$data['fullName'] ||
            !$data['email'] ||
            !$data['phone'] ||
            !$data['dateFrom'] ||
            !$data['dateTo'] ||
            empty($data['rooms'])
        ) {
            http_response_code(400);
            echo 'Nieprawidłowe dane rezerwacji';
            return;
        }

        $repo = new BookingRepository();
        $repo->create($data);

        header('Location: /booking/success');
        exit;
    }
}