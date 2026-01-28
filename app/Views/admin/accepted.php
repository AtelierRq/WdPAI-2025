<section class="admin-bookings">
    <div class="container">
        <h1>Zaakceptowane rezerwacje</h1>

        <?php if (empty($bookings)): ?>
            <p>Brak oczekujących rezerwacji.</p>
        <?php else: ?>
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-card">
                    <div class="booking-header">
                        <strong><?= htmlspecialchars($booking['full_name']) ?></strong>
                        <span><?= htmlspecialchars($booking['email']) ?></span>
                    </div>

                    <div class="booking-body">
                        <p><strong>Telefon:</strong> <?= htmlspecialchars($booking['phone']) ?></p>
                        <p><strong>Termin:</strong>
                            <?= $booking['date_from'] ?> →
                            <?= $booking['date_to'] ?>
                        </p>

                        <p><strong>Osoby:</strong>
                            Dorośli: <?= $booking['adults'] ?>,
                            Dzieci: <?= $booking['children'] ?>,
                            Niemowlęta: <?= $booking['infants'] ?>
                        </p>

                        <p><strong>Pokoje:</strong>
                            <?php
                            $rooms = trim($booking['rooms'], '{}');
                            echo htmlspecialchars(str_replace(',', ', ', $rooms));
                            ?>
                        </p>

                        <?php if ($booking['breakfast']): ?>
                            <p><strong>Śniadanie:</strong> Tak</p>
                        <?php endif; ?>

                        <?php if (!empty($booking['notes'])): ?>
                            <p><strong>Uwagi:</strong>
                                <?= nl2br(htmlspecialchars($booking['notes'])) ?>
                            </p>
                        <?php endif; ?>

                        <p class="price">
                            <strong>Łączna cena:</strong>
                            <?= $booking['total_price'] ?> zł
                        </p>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>