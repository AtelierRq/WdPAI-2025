<section class="booking">
    <div class="container booking-container">

        <h1>Zarezerwuj pobyt</h1>
        <p class="booking-subtitle">
            Wypełnij formularz, aby zarezerwować pobyt w Osadzie Dębowy Jar.
        </p>

        <form class="booking-form" id="bookingForm" method="post" action="/booking" novalidate>

            <!-- DATY -->
            <div class="form-row">
                <div class="form-group">
                    <label>Data przyjazdu (zameldowanie po 14:00)</label>
                    <input type="date" id="dateFrom" name="dateFrom">
                </div>

                <div class="form-group">
                    <label>Data wyjazdu (wymeldowanie do 11:00)</label>
                    <input type="date" id="dateTo" name="dateTo">
                </div>
            </div>

            <!-- IMIĘ I NAZWISKO -->
            <div class="form-group">
                <label>Imię i nazwisko</label>
                <input type="text" id="fullName" name="fullName" placeholder="Jan Kowalski">
            </div>

            <!-- EMAIL -->
            <div class="form-group">
                <label>Adres e-mail</label>
                <input type="email" id="email" name="email" placeholder="jan.kowalski@example.com">
            </div>

            <!-- TELEFON -->
            <div class="form-group">
                <label>Numer telefonu</label>
                <input type="tel" id="phone" name="phone" placeholder="+48 123 456 789">
            </div>

            <!-- OSOBY -->
            <div class="form-group">
                <label>Dorośli (od 11 lat)</label>
                <input type="number" id="adults" name="adults" min="1" value="1">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Dzieci (1–10 lat)</label>
                    <input type="number" id="children" name="children" min="0" value="0">
                </div>

                <div class="form-group">
                    <label>Niemowlęta (do 12 miesięcy)</label>
                    <input type="number" id="infants" name="infants" min="0" value="0">
                </div>
            </div>


            <!-- POKOJE -->
            <h3>Pokoje</h3>

            <div id="roomsContainer">
                <div class="room-row">
                    <select class="room-select">
                        <option value="">-- wybierz pokój --</option>
                    </select>
                    <button type="button" class="remove-room" disabled>✕</button>
                </div>
            </div>

            <button class="main-nav" type="button" id="addRoomBtn">+ Dodaj kolejny pokój</button>

            <!-- ŚNIADANIE -->
            <div class="form-group">
                <label>
                    <input type="checkbox" id="breakfast" name="breakfast">
                    Śniadanie (40 zł / osoba / doba)
                </label>
            </div>

            <!-- UWAGI -->
            <div class="form-group">
                <label>Dodatkowe uwagi</label>
                <textarea name="notes" placeholder="Np. łóżeczko dla niemowlęcia"></textarea>
            </div>

            <!-- BŁĘDY -->
            <p id="priceError" class="price-error"></p>

            <!-- CENA -->
            <div class="price-box">
                <strong>Łączna cena:</strong>
                <span id="totalPrice">0 zł</span>
            </div>

            <!-- UKRYTE POLA -->
            <input type="hidden" name="rooms" id="roomsInput">
            <input type="hidden" name="price" id="priceInput">

            <button type="submit" class="btn-primary" id="submitBtn" disabled>Zarezerwuj</button>

        </form>

    </div>
</section>

<script src="/assets/js/booking-price.js"></script>