<?php
/*
use PHPUnit\Framework\TestCase;
use App\Repositories\BookingRepository;
use App\Database\Database;

class BookingRepositoryTest extends TestCase
{
    private BookingRepository $repo;

    protected function setUp(): void
    {
        // Upewnij się, że sesja istnieje
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->repo = new BookingRepository();
    }

    public function testCreateAndUpdateBookingStatus(): void
    {
        $data = [
            'user_id'   => 1,
            'fullName'  => 'Test User',
            'email'     => 'test.user@example.com',
            'phone'     => '+48123456789',
            'dateFrom'  => '2026-03-01',
            'dateTo'    => '2026-03-03',
            'adults'    => 2,
            'children'  => 1,
            'infants'   => 0,
            'breakfast' => true,
            'notes'     => 'Testowa rezerwacja',
            'price'     => 300,
            'rooms'     => [1],
        ];

        // CREATE
        $bookingId = $this->repo->create($data);
        $this->assertIsInt($bookingId);

        // READ (pending)
        $pending = $this->repo->getByStatus('pending');
        $this->assertNotEmpty($pending);

        // UPDATE
        $this->repo->updateStatus($bookingId, 'accepted');

        $accepted = $this->repo->getByStatus('accepted');
        $ids = array_column($accepted, 'id');

        $this->assertContains($bookingId, $ids);
    }
}
*/