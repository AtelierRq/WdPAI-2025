<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\BookingRepository;

class AdminBookingController extends Controller
{
    private BookingRepository $bookingRepository;

    public function __construct()
    {

        // ochrona admina
        if (
            empty($_SESSION['user']) ||
            ($_SESSION['user']['role'] ?? null) !== 'admin'
        ) {
            http_response_code(403);
            echo 'Brak dostępu';
            exit;
        }

        $this->bookingRepository = new BookingRepository();
    }

    public function pending(): void
    {
        $bookings = $this->bookingRepository->getByStatus('pending');

        $this->view('admin/pending', [
            'bookings' => $bookings,
        ]);
    }

    public function accepted(): void
    {
        $bookings = $this->bookingRepository->getByStatus('accepted');

        $this->view('admin/accepted', [
            'bookings' => $bookings,
        ]);
    }

    public function rejected(): void
    {
        $bookings = $this->bookingRepository->getByStatus('rejected');

        $this->view('admin/rejected', [
            'bookings' => $bookings,
        ]);
    }

    public function accept(int $id): void
    {
        $this->bookingRepository->updateStatus($id, 'accepted');

        header('Location: /admin/bookings/pending');
        exit;
    }

    public function reject(int $id): void
    {
        $this->bookingRepository->updateStatus($id, 'rejected');

        header('Location: /admin/bookings/pending');
        exit;
    }
}