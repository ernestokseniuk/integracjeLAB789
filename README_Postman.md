# Kolekcja Postman - Laboratorium Integracji Systemów

## 📋 Opis

Kompletna kolekcja zapytań Postman dla trzech projektów laboratoryjnych:
- **Lab 7**: REST API z bazą danych World (PHP/MySQL)
- **Lab 8**: JWT Authentication API (.NET Core)
- **Lab 9**: Poziomy izolacji transakcji (PHP/MySQL/Sakila)

## 🚀 Instalacja i Uruchomienie

### 1. Import kolekcji do Postman

1. Otwórz Postman
2. Kliknij **Import** w lewym górnym rogu
3. Wybierz plik `Postman_Collection_Labs.json`
4. Kolekcja zostanie zaimportowana z wszystkimi zmiennymi środowiskowymi

### 2. Przygotowanie projektów

#### Lab 7 - REST API World Database
```bash
cd lab7
docker-compose up -d
# API dostępne pod: http://localhost:8080
```

#### Lab 8 - JWT Authentication API
```bash
cd lab8/lab8
dotnet run
# API dostępne pod: http://localhost:8080
```

#### Lab 9 - Transaction Isolation Demo
```bash
cd lab9
docker-compose up -d
# Aplikacja dostępna pod: http://localhost:8081
```

## 📚 Struktura Kolekcji

### LAB 7 - REST API World Database

**Endpointy:**
- `GET /api/read_countries.php` - Lista wszystkich krajów
- `GET /api/read_cities.php` - Lista wszystkich miast
- `GET /api/read_single_country.php?id=POL` - Szczegóły kraju
- `POST /api/create_country.php` - Utworzenie nowego kraju
- `GET /api/read_cities.php?country_code=POL` - Miasta w kraju

**Przykładowe dane do testowania:**
```json
{
    "code": "TST",
    "name": "Test Country",
    "continent": "Europe",
    "region": "Northern Europe",
    "surface_area": 1000.50,
    "population": 1000000,
    "life_expectancy": 75.5,
    "gnp": 50000.00,
    "local_name": "Test Country Local",
    "government_form": "Republic",
    "head_of_state": "Test President",
    "code2": "TS"
}
```

### LAB 8 - JWT Authentication API

**Użytkownicy testowi:**
- **Andrzej/Andrzej** - Role: `admin`, `user`
- **Piotrek/Piotrek** - Role: `number`, `user`
- **Ania/Ania** - Role: `user`

**Endpointy:**

1. **Authentication:**
   - `POST /api/users/authenticate` - Logowanie (zwraca JWT token)

2. **Protected Endpoints:**
   - `GET /api/users` - Lista użytkowników (wymaga roli `admin`)
   - `GET /api/users/count` - Liczba użytkowników (wymaga roli `user`)
   - `GET /api/numbers/random-prime` - Losowa liczba pierwsza (wymaga roli `number`)

**Automatyzacja:**
- Token JWT jest automatycznie zapisywany po logowaniu
- Wszystkie chronione endpointy używają zapisanego tokenu
- Testy nieautoryzowanego dostępu (401/403)

### LAB 9 - Transaction Isolation Demo

**Strony aplikacji:**
- `GET /index1.php` - Główne menu
- `GET /read-committed.php` - Test READ COMMITTED
- `GET /repetable-read.php` - Test REPEATABLE READ

**Operacje na bazie:**
- `GET /select-adam.php` - Pokaż aktorów o imieniu ADAM
- `GET /update-adam.php` - Zmień ADAM → CHRIS
- `GET /update-chris.php` - Zmień CHRIS → ADAM

## 🧪 Instrukcje Testowania

### Lab 7 - REST API
1. Uruchom `docker-compose up -d` w folderze lab7
2. Testuj endpointy w kolejności:
   - Pobierz kraje
   - Pobierz miasta
   - Utwórz nowy kraj
   - Pobierz szczegóły kraju

### Lab 8 - JWT Authentication

#### Test autoryzacji:
1. **Zaloguj się jako Andrzej:**
   - Wykonaj zapytanie "Login - Andrzej (Admin)"
   - Token zostanie automatycznie zapisany

2. **Testuj endpointy z rolą admin:**
   - `GET /api/users` ✅ (ma rolę admin)
   - `GET /api/users/count` ✅ (ma rolę user)
   - `GET /api/numbers/random-prime` ❌ (brak roli number)

3. **Zaloguj się jako Piotrek:**
   - Wykonaj zapytanie "Login - Piotrek (Number)"

4. **Testuj endpointy z rolą number:**
   - `GET /api/users` ❌ (brak roli admin)
   - `GET /api/users/count` ✅ (ma rolę user)
   - `GET /api/numbers/random-prime` ✅ (ma rolę number)

5. **Zaloguj się jako Ania:**
   - Wykonaj zapytanie "Login - Ania (User Only)"

6. **Testuj endpointy z rolą user:**
   - `GET /api/users` ❌ (brak roli admin)
   - `GET /api/users/count` ✅ (ma rolę user)
   - `GET /api/numbers/random-prime` ❌ (brak roli number)

### Lab 9 - Transaction Isolation

#### Test READ COMMITTED:
1. Otwórz w przeglądarce: `http://localhost:8081/read-committed.php`
2. Strona wykona pierwsze zapytanie i będzie czekać 20 sekund
3. **W tym czasie** otwórz nową kartę i wykonaj: `update-adam.php`
4. Sprawdź wynik w: `select-adam.php`
5. Wróć do pierwszej karty i zobacz różnicę w wynikach

**Oczekiwany rezultat:** Drugie zapytanie pokaże zaktualizowane dane (dirty read)

#### Test REPEATABLE READ:
1. Otwórz w przeglądarce: `http://localhost:8081/repetable-read.php`
2. Strona wykona pierwsze zapytanie i będzie czekać 20 sekund
3. **W tym czasie** otwórz nową kartę i wykonaj: `update-adam.php`
4. Sprawdź wynik w: `select-adam.php`
5. Wróć do pierwszej karty i zobacz wyniki

**Oczekiwany rezultat:** Drugie zapytanie pokaże te same dane (ochrona przed non-repeatable read)

## 🔧 Zmienne Środowiskowe

Kolekcja używa następujących zmiennych:

- `lab7_base_url`: `http://localhost:8080` (REST API)
- `lab8_base_url`: `http://localhost:8080` (JWT API)
- `lab9_base_url`: `http://localhost:8081` (Transaction Demo)
- `jwt_token`: automatycznie ustawiana po logowaniu

## 📝 Notatki

### Lab 7
- Baza danych World jest automatycznie ładowana przy starcie kontenera
- API endpoint'y mogą być puste - sprawdź pliki w `rest_api/api/`
- Użyj MySQL Workbench do podglądu bazy: `localhost:3306`

### Lab 8
- Aplikacja musi być uruchomiona z `dotnet run`
- JWT tokeny wygasają po określonym czasie
- Sprawdź logi aplikacji w przypadku błędów 500

### Lab 9
- Używa bazy Sakila (filmy/aktorzy)
- Demonstracja wymaga manual testing w przeglądarce
- Postman służy do szybkiego dostępu do endpointów
- Baza dostępna na `localhost:3307` (zewnętrzny port)

## 🐛 Rozwiązywanie Problemów

### Lab 7
```bash
# Sprawdź status kontenerów
docker-compose ps

# Sprawdź logi
docker-compose logs web
docker-compose logs db
```

### Lab 8
```bash
# Sprawdź, czy aplikacja działa
curl http://localhost:8080/api/users/authenticate

# Sprawdź logi .NET
dotnet run --verbosity normal
```

### Lab 9
```bash
# Sprawdź status kontenerów
docker-compose ps

# Zrestartuj jeśli potrzeba
docker-compose down && docker-compose up -d
```

## 📞 Kontakt

W przypadku problemów sprawdź:
1. Czy wszystkie kontenery/aplikacje są uruchomione
2. Czy porty nie są zajęte
3. Czy zmienne środowiskowe są poprawnie ustawione
4. Logi aplikacji/kontenerów

---

**Autor:** System Integracji - Laboratoria  
**Data:** Czerwiec 2025
