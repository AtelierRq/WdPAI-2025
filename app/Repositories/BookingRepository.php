<?php

namespace App\Repositories;

use App\Database\Database;
use PDO;

class BookingRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create(array $data): int
    {
        $this->db->beginTransaction();

        try {
            // 1. bookings
            $stmt = $this->db->prepare("
                INSERT INTO bookings (
                    user_id,
                    full_name,
                    email,
                    phone,
                    date_from,
                    date_to,
                    adults,
                    children,
                    infants,
                    breakfast,
                    notes,
                    total_price
                ) VALUES (
                    :user_id,
                    :full_name,
                    :email,
                    :phone,
                    :date_from,
                    :date_to,
                    :adults,
                    :children,
                    :infants,
                    :breakfast,
                    :notes,
                    :price
                )
                RETURNING id
            ");

            $stmt->execute([
                'user_id'   => $data['user_id'],
                'full_name' => $data['fullName'],
                'email'     => $data['email'],
                'phone'     => $data['phone'],
                'date_from' => $data['dateFrom'],
                'date_to'   => $data['dateTo'],
                'adults'    => $data['adults'],
                'children'  => $data['children'],
                'infants'   => $data['infants'],
                'breakfast' => $data['breakfast'],
                'notes'     => $data['notes'],
                'price'     => $data['price'],
            ]);

            $bookingId = $stmt->fetchColumn();

            // 2. booking_rooms
            $stmtRoom = $this->db->prepare("
                INSERT INTO booking_rooms (booking_id, room_id)
                VALUES (:booking_id, :room_id)
            ");

            foreach ($data['rooms'] as $roomId) {
                $stmtRoom->execute([
                    'booking_id' => $bookingId,
                    'room_id' => $roomId
                ]);
            }

            $this->db->commit();
            return $bookingId;

        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getByStatus(string $status): array
    {
        $sql = "
            SELECT
                b.id,
                b.full_name,
                b.email,
                b.phone,
                b.date_from,
                b.date_to,
                b.adults,
                b.children,
                b.infants,
                b.breakfast,
                b.notes,
                b.total_price,
                b.status,
                b.created_at,
                ARRAY_AGG(r.name ORDER BY r.name) AS rooms
            FROM bookings b
            JOIN booking_rooms br ON br.booking_id = b.id
            JOIN rooms r ON r.id = br.room_id
            WHERE b.status = :status
            GROUP BY b.id
            ORDER BY b.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'status' => $status,
        ]);

        return $stmt->fetchAll();
    }

    public function updateStatus(int $id, string $status): void
    {
        $stmt = $this->db->prepare("
            UPDATE bookings
            SET status = :status
            WHERE id = :id
        ");

        $stmt->execute([
            'id' => $id,
            'status' => $status,
        ]);
    }
}