# Dębowy Jar Aplikacja

Ta aplikacja służy do rezerwacji noclegów w hostelu, a konkretnie w Osadzie Turystycznej „Dębowy Jar”. Aplikacja pozwala gościom wybrać dogodny termin wizyty. Po wybraniu i wprowadzeniu niezbędnych informacji, właściciel otrzymuje prośbę o rezerwację, którą może zaakceptować lub odrzucić. Oprócz dat rezerwacji, aplikacja zawiera również inne informacje, takie jak informacje o hostelu oraz małą galerię zdjęć. Całość utrzymana jest w kolorystyce pomarańczowo-biało-czarnej.


# Baza Danych

* Baza obsługuje trzy główne obszary aplikacji: użytkowników, rezerwacje, relacje rezerwacja-pokój.
* Baza została wykonana zgodnie z zasadami normalizacji i standardu 3NF. 
* Zawiera relacje typu jeden-do-wielu (jeden użytkownik może mieć wiele rezerwacji), wiele-do-wielu (jeden pokój może mieć wiele rezerwacji (w czasie)) oraz jeden-do-jednego (jeden użytkownik może mieć jeden profil). 
* Dodałem 2 widoki z uwzględnieniem JOIN, wyzwalacz oraz funkcję. 
* Operacje zapisu są w transakcjach, aby dane były spójne. Transakcje realizowane są na poziomie READ COMMITTED.
* dump bazy danych znajduje się w pliku "debowyjar.sql".
