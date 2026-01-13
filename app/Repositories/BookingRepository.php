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
}