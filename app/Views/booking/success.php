<section class="booking-success">
    <div class="container success-container">

        <div class="success-icon">✓</div>

        <h1>Dziękujemy za rezerwację!</h1>
        <p class="success-text">
            Rezerwacja została pomyślnie złożona.
        </p>

        <div class="success-card">
            <h3>Podsumowanie rezerwacji</h3>

            <ul class="success-summary">
                <li><strong>Termin pobytu:</strong>
                    <?= htmlspecialchars($booking['dateFrom']) ?> – <?= htmlspecialchars($booking['dateTo']) ?>
                </li>

                <li><strong>Imię i nazwisko:</strong>
                    <?= htmlspecialchars($booking['fullName']) ?>
                </li>

                <li><strong>E-mail:</strong>
                    <?= htmlspecialchars($booking['email']) ?>
                </li>

                <li><strong>Telefon:</strong>
                    <?= htmlspecialchars($booking['phone']) ?>
                </li>

                <li><strong>Łączna cena:</strong>
                    <?= (int)$booking['price'] ?> zł
                </li>
            </ul>

            <div class="success-info">
                Państwa rezerwacja oczekuje na akceptację przez właściciela.
                Potwierdzenie otrzymają Państwo w ciągu 24 godzin.
            </div>
        </div>

        <a href="/" class="btn-primary">
            Wróć do strony głównej
        </a>

    </div>
</section>