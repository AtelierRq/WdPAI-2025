<h1>Moje rezerwacje</h1>

<?php if (empty($bookings)): ?>
    <p>Nie masz jeszcze żadnych rezerwacji.</p>
<?php endif; ?>

<?php foreach ($bookings as $booking): ?>
    <div class="booking-card">
        <p><strong>Termin:</strong>
            <?= $booking['date_from'] ?> → <?= $booking['date_to'] ?>
        </p>

        <p><strong>Pokoje:</strong> <?= htmlspecialchars($booking['rooms']) ?></p>

        <p><strong>Osoby:</strong>
            Dorośli: <?= $booking['adults'] ?>,
            Dzieci: <?= $booking['children'] ?>,
            Niemowlęta: <?= $booking['infants'] ?>
        </p>

        <p><strong>Śniadanie:</strong>
            <?= $booking['breakfast'] ? 'Tak' : 'Nie' ?>
        </p>

        <p><strong>Łączna cena:</strong>
            <?= $booking['total_price'] ?> zł
        </p>

        <p><strong>Status:</strong>
            <?php
            echo match ($booking['status']) {
                'pending'  => '⏳ W toku',
                'accepted' => '✅ Zaakceptowana',
                'rejected' => '❌ Odrzucona',
                default    => $booking['status'],
            };
            ?>
        </p>

        <hr>
    </div>
<?php endforeach; ?>