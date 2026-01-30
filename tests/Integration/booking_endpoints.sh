#!/bin/bash

BASE_URL="http://localhost:8080"
COOKIE_FILE="cookies.txt"

echo "===> TEST: logowanie admina"

curl -s -c $COOKIE_FILE -X POST "$BASE_URL/login" \
  -d "email=admin@debowyjar.pl" \
  -d "password=admin123" \
  -o /dev/null

if [ $? -ne 0 ]; then
  echo " Błąd logowania"
  exit 1
fi

echo " Zalogowano admina"

echo "===> TEST: pobranie oczekujących rezerwacji"

STATUS_CODE=$(curl -s -b $COOKIE_FILE -o /dev/null -w "%{http_code}" \
  "$BASE_URL/admin/bookings/pending")

if [ "$STATUS_CODE" != "200" ]; then
  echo " Oczekiwano 200, otrzymano $STATUS_CODE"
  exit 1
fi

echo " Endpoint pending działa (200)"

echo "===> TEST: próba dostępu bez uprawnień"

curl -s -X GET "$BASE_URL/admin/bookings/pending" -o /dev/null -w "%{http_code}" \
  | grep -q "403"

if [ $? -ne 0 ]; then
  echo " Brak 403 dla niezalogowanego użytkownika"
  exit 1
fi

echo " Poprawnie zwrócono 403"

echo " Test integracyjny zakończony sukcesem"