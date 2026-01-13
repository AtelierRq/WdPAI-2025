<?php

namespace App\Controllers;

use App\Core\Controller;

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
        
        // 1. Pobranie danych
        $data = [
            'fullName'  => trim($_POST['fullName'] ?? ''),
            'email'     => trim($_POST['email'] ?? ''),
            'phone'     => trim($_POST['phone'] ?? ''),
            'dateFrom'  => $_POST['dateFrom'] ?? '',
            'dateTo'    => $_POST['dateTo'] ?? '',
            'adults'    => (int) ($_POST['adults'] ?? 0),
            'children'  => (int) ($_POST['children'] ?? 0),
            'infants'   => (int) ($_POST['infants'] ?? 0),
            'rooms'     => $_POST['rooms'] ?? [],
            'breakfast' => isset($_POST['breakfast']),
            'notes'     => trim($_POST['notes'] ?? ''),
            'price'     => (int) ($_POST['price'] ?? 0),
        ];

        // 2. Walidacja backendowa (minimum)
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

        // 3. Tymczasowy zapis do sesji (mock DB)
        $_SESSION['bookings'][] = $data;

        // 4. Redirect
        header('Location: /booking/success');
        exit;
    }
}