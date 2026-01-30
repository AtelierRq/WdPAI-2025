# Dębowy Jar Aplikacja

Ta aplikacja służy do rezerwacji noclegów w hostelu, a konkretnie w Osadzie Turystycznej „Dębowy Jar”. Aplikacja pozwala gościom wybrać dogodny termin wizyty. Po wybraniu i wprowadzeniu niezbędnych informacji, właściciel otrzymuje prośbę o rezerwację, którą może zaakceptować lub odrzucić. Oprócz dat rezerwacji, aplikacja zawiera również inne informacje, takie jak informacje o hostelu oraz małą galerię zdjęć. Całość utrzymana jest w kolorystyce pomarańczowo-biało-czarnej.

# Zrzuty ekranu aplikacji

<img width="1902" height="907" alt="image" src="https://github.com/user-attachments/assets/e6d7383c-8cbf-4805-a83a-81c6a3065d57" />
<img width="1901" height="707" alt="image" src="https://github.com/user-attachments/assets/33715a41-0a94-496e-91da-97ffea6f99e6" />
<img width="1915" height="906" alt="image" src="https://github.com/user-attachments/assets/143a3a6d-5d50-4a36-9303-d62b677f5512" />
<img width="1902" height="907" alt="image" src="https://github.com/user-attachments/assets/8cc01693-8952-4c13-9264-91ffd29fea9d" />
<img width="1901" height="689" alt="image" src="https://github.com/user-attachments/assets/f361b5fe-13a4-4089-9230-ac8fd9fff8d0" />
<img width="1901" height="907" alt="image" src="https://github.com/user-attachments/assets/f1b91ff1-20a2-4b01-810c-f681b2e73f5f" />
<img width="1914" height="843" alt="image" src="https://github.com/user-attachments/assets/aaa51a78-1158-41a2-8c6f-8ba66ad04731" />
<img width="1913" height="631" alt="image" src="https://github.com/user-attachments/assets/4b39c5ea-0a0b-447b-9082-3967e401277d" />
<img width="1902" height="902" alt="image" src="https://github.com/user-attachments/assets/6829265b-e0a1-4b15-b600-ad5cf08ce96e" />
<img width="368" height="823" alt="image" src="https://github.com/user-attachments/assets/0412721f-7f95-4137-8fab-32a03affe551" />
<img width="371" height="823" alt="image" src="https://github.com/user-attachments/assets/3d035509-06be-48c0-9d6a-331503a62a93" />
<img width="369" height="822" alt="image" src="https://github.com/user-attachments/assets/02c8da0d-9521-44ce-a23a-7c6444f894ec" />


# Baza Danych

* Baza obsługuje trzy główne obszary aplikacji: użytkowników, rezerwacje, relacje rezerwacja-pokój.
* Baza została wykonana zgodnie z zasadami normalizacji i standardu 3NF. 
* Zawiera relacje typu jeden-do-wielu (jeden użytkownik może mieć wiele rezerwacji), wiele-do-wielu (jeden pokój może mieć wiele rezerwacji (w czasie)) oraz jeden-do-jednego (jeden użytkownik może mieć jeden profil). 
* Dodałem 2 widoki z uwzględnieniem JOIN, wyzwalacz oraz funkcję. 
* Operacje zapisu są w transakcjach, aby dane były spójne. Transakcje realizowane są na poziomie READ COMMITTED.
* dump bazy danych znajduje się w pliku "debowyjar.sql".

# Diagram ERD

Utworzony na stronie: https://dbdiagram.io/
<img width="1202" height="744" alt="image" src="https://github.com/user-attachments/assets/eb6b964b-d1fd-4713-832c-95083266d194" />


# Diagram Warstwowy

<img width="255" height="703" alt="image" src="https://github.com/user-attachments/assets/a4940e15-5558-49de-9474-dfe5db32ba0e" />

# Instrukcja uruchomienia aplikacji (Docker)

1. Trzeba zweryfikować czy na pewno znajduje się w projekcie plik .env z poprawnymi danymi.
2. Aby uruchomić aplikację wraz z bazą danych (baza danych PostgreSQL (wewnątrz Dockera)), w katalogu głównym projektu wykonujemy:
   * docker-compose up -d
3. Następnie mamy na naszym localhoście działa aplikacja: http://localhost:8080
4. W celu zatrzymania aplikacji:
   * docker-compose down
  
* Konfiguracja znajduje się w docker-compose.yaml

# Scenariusz testowy aplikacji

1. Rejestracja użytkownika (CREATE – users)
   Użytkownik wchodzi na stronę główną, klika "Rejestracja", podaje dane (imie, nazwisko, email, haslo) i jego konto zostaje poprawnie utworzone w bazie danych.
2. Logowanie użytkownika (READ – auth)
   Użytkownik przechodzi na stronę logowania, podaje swoje dane niezbędne do zalogowania i jeśli dane są poprawne to przechodzi do strony głównej jako użytkownik zalogowany. Pojawia się jego adres email na pasku nawigacji oraz ma on teraz dostęp do jego dokonanych rezerwacji.
3. Próba dostępu do panelu admina (401 / 403)
   Zalogowany użytkownik typu 'user' próbuje przejść na jakąś ze stron admina, np. /admin/bookings/pending, ale system zwraca 403 - brak dostępu.
4. Złożenie rezerwacji (CREATE – bookings)
   Zalogowany użytkownik klika "Rezerwuj", wypełnia pełen formularz, jego rezerwacja zostaje zapisana w 'bookings' oraz jej status ustawiony na 'pending'. Na ekranie wyświetla się potwierdzenie rezerwacji.
5. Widok „Moje rezerwacje” (READ)
   Użytkownik przechodzi do zakładki "Moje rezerwacje" gdzie widoczne są rezerwacje tylko tego użytkownika oraz ich status.
6. Logowanie administratora
   Administrator loguje się na swoje konto z rolą 'admin'. Widzi dodatkowe sekcje na pasku nawigacji takie jak: Oczekujące, Zaakceptowane, Odrzucone.
7. Zarządzanie rezerwacjami (UPDATE – admin)
   Administrator wchodzi w "Oczekujące rezerwacje" i wybiera "Akceptuj" lub "Odrzuć", po czym zmienia się status danej rezerwacji na "accpeted" lub "rejected". Rezerwacja taka znika z "Oczekujące" i znajduje się teraz w odpowiedniej zakładce.
8. Widoki admina (READ + JOIN)
   Admin przechodzi między zakładkami w celu weryfikacji czy wszyskie rezerwacje są tam gdzie powinny. Dane są pobierane z wielu tabel.
9. Wylogowanie
   Admin klika "Wyloguj", sesja zostaje usunięta, użytkownik wraca do stanu niezalogowanego oraz powracają przyciski "Logowanie" oraz "Rejestracja" na pasku nawigacji
   

# Checklista z tym co udało się zrealizować:

Technologie i narzędzia:
PHP, HTML5, CSS, JavaScript (Fetch API - AJAX), PostgreSQL, Docker + docker-compose, Git, bez użycia frameworków

Architektura aplikacji:
Model - repozytoria
View - Widoki PHP
Controller - kontrolery

Wyraźny podział na frontend i backend, routing, obsługa błędów.

Użytkownicy i autoryzacja:
System logowania i rejstracji
Hasła haszowane i weryfikowane
Obsługa sesji użytkowników
Dwie role - user i admin
