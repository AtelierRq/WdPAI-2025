<section class="booking">
    <div class="container booking-container">

        <h1>Zarezerwuj pobyt</h1>
        <p class="booking-subtitle">
            Wypełnij formularz, aby zarezerwować pobyt w Osadzie Dębowy Jar.
        </p>

        <form class="booking-form">

            <div class="form-group">
                <label>Data przyjazdu</label>
                <input type="date">
            </div>

            <div class="form-group">
                <label>Data wyjazdu</label>
                <input type="date">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Liczba dorosłych</label>
                    <input type="number" min="1" value="2">
                </div>

                <div class="form-group">
                    <label>Liczba dzieci</label>
                    <input type="number" min="0" value="0">
                </div>
            </div>

            <div class="form-group">
                <label>Imię i nazwisko</label>
                <input type="text" placeholder="Jan Kowalski">
            </div>

            <div class="form-group">
                <label>Adres e-mail</label>
                <input type="email" placeholder="jan.kowalski@example.com">
            </div>

            <div class="form-group">
                <label>Numer telefonu</label>
                <input type="tel" placeholder="+48 123 456 789">
            </div>

            <div class="form-group">
                <label>Dodatkowe uwagi</label>
                <textarea placeholder="Np. łóżeczko dla dziecka"></textarea>
            </div>

            <button type="submit" class="btn-primary">
                Zarezerwuj
            </button>

        </form>

    </div>
</section>