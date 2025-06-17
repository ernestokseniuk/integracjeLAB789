# Lab 7 - REST API w Docker

## 🎯 Cel laboratorium
Tworzenie i uruchamianie aplikacji REST API w kontenerach Docker z bazą danych MySQL.

## 📁 Struktura projektu
```
lab7/
├── docker-compose.yml          # Konfiguracja kontenerów
├── db_dumps/
│   └── world.sql              # Dump bazy danych world
└── rest_api/
    ├── Dockerfile             # Obraz Docker dla PHP/Apache
    ├── index.php              # Strona główna API
    ├── api/
    │   ├── read_countries.php    # GET /api/read_countries.php
    │   ├── read_single_country.php # GET /api/read_single_country.php?code=POL
    │   ├── create_country.php    # POST /api/create_country.php
    │   └── read_cities.php       # GET /api/read_cities.php
    ├── config/
    │   └── Database.php          # Konfiguracja połączenia z bazą
    └── models/
        ├── Country.php           # Model kraju
        └── City.php              # Model miasta
```

## 🐳 Uruchomienie aplikacji

### 1. Budowanie i uruchamianie kontenerów
```bash
cd lab7
docker-compose -p lab7_dockertest up -d --build
```

### 2. Sprawdzenie statusu kontenerów
```bash
docker-compose ps
```

### 3. Sprawdzenie logów
```bash
docker-compose logs
```

## 🌐 Dostęp do aplikacji

- **REST API**: http://localhost:8000
- **Interfejs krajów**: http://localhost:8000/countries.html
- **Interfejs miast**: http://localhost:8000/cities.html
- **Dokumentacja API**: http://localhost:8000/api-docs.html
- **MySQL Database**: localhost:3306
  - Database: `world`
  - User: `root`
  - Password: (brak)

## 📚 Dostępne endpointy REST API

### Countries (Kraje)
- `GET /api/read_countries.php` - Lista wszystkich krajów
- `GET /api/read_single_country.php?code=POL` - Szczegóły kraju po kodzie
- `POST /api/create_country.php` - Utworzenie nowego kraju

### Cities (Miasta)  
- `GET /api/read_cities.php` - Lista wszystkich miast
- `GET /api/read_cities.php?country=POL` - Miasta w danym kraju

## 🧪 Przykłady testowania

### 1. Przeglądarka - Interfejs Web
- **http://localhost:8000** - Strona główna API
- **http://localhost:8000/countries.html** - Zarządzanie krajami
  - Wyświetlanie listy krajów z filtrowaniem i wyszukiwaniem
  - Dodawanie nowych krajów
  - Szczegóły krajów
  - Statystyki krajów
- **http://localhost:8000/cities.html** - Przeglądanie miast
  - Lista wszystkich miast z paginacją
  - Filtrowanie po krajach
  - Sortowanie po różnych kolumnach
  - Statystyki miast
- **http://localhost:8000/api-docs.html** - Kompletna dokumentacja API

### 2. Przeglądarka - Endpointy API
- http://localhost:8000/api/read_countries.php - Lista krajów
- http://localhost:8000/api/read_single_country.php?code=POL - Polska
- http://localhost:8000/api/read_cities.php?country=POL - Miasta w Polsce

### 2. Postman
Importuj kolekcję z `../Postman_Collection_Labs.json` i zmień URL na `localhost:8000`

### 3. cURL
```bash
# Lista krajów
curl http://localhost:8000/api/read_countries.php

# Szczegóły Polski
curl http://localhost:8000/api/read_single_country.php?code=POL

# Miasta w Polsce
curl http://localhost:8000/api/read_cities.php?country=POL

# Tworzenie nowego kraju
curl -X POST http://localhost:8000/api/create_country.php \
  -H "Content-Type: application/json" \
  -d '{
    "code": "TST",
    "name": "Test Country",
    "continent": "Europe",
    "region": "Test Region",
    "surface_area": 1000.00,
    "population": 1000000,
    "local_name": "Test Country",
    "government_form": "Republic",
    "code2": "TS"
  }'
```

## 🛑 Zatrzymywanie aplikacji

```bash
# Zatrzymanie kontenerów
docker-compose down

# Zatrzymanie z usunięciem wolumenów
docker-compose down -v
```

## 🔧 Komponenty techniczne

### Kontenery Docker:
- **myfirst_dockerized_rest_server** - Serwer PHP/Apache (port 8000)
- **myfirst_dockerized_database_server** - MySQL 8.0 (port 3306)

### Konfiguracja:
- PHP 7.2 z Apache
- Rozszerzenie mysqli
- Baza danych world z przykładowymi danymi
- Automatyczna inicjalizacja bazy z pliku SQL

## 📋 Wymagania spełnione:

✅ **Z.7.1** - Zmodyfikowana struktura projektu  
✅ **Z.7.2** - Dockerfile i docker-compose.yml  
✅ **Z.7.3** - Uruchomienie aplikacji w Docker  
✅ **Z.7.4** - Testy funkcjonalności REST API  
✅ **Z.7.5** - Zatrzymywanie aplikacji  

## 🔍 Funkcje REST API:

- **CORS Headers** - Obsługa zapytań cross-origin
- **JSON Response** - Wszystkie odpowiedzi w formacie JSON
- **Error Handling** - Odpowiednie kody odpowiedzi HTTP
- **Database Relations** - Obsługa relacji między tabelami
- **Parameter Validation** - Walidacja parametrów wejściowych

## 🎨 Funkcje interfejsu Web:

### Zarządzanie krajami (countries.html):
- ✅ Responsywna lista krajów w formie kart
- ✅ Wyszukiwanie po nazwie, kodzie, kontynencie i regionie
- ✅ Statystyki krajów (liczba, ludność, średnie PKB)
- ✅ Formularz dodawania nowych krajów z walidacją
- ✅ Szczegóły krajów w modalach
- ✅ Przejście do miast danego kraju

### Przeglądanie miast (cities.html):
- ✅ Tabela miast z sortowaniem po kolumnach
- ✅ Paginacja dla dużych zbiorów danych (50 miast na stronę)
- ✅ Filtrowanie po krajach i wyszukiwanie
- ✅ Statystyki miast (liczba, ludność, kraje)
- ✅ Responsywny design dla urządzeń mobilnych
- ✅ Automatyczne ładowanie przy parametrze kraju w URL

### Dokumentacja API (api-docs.html):
- ✅ Kompletna dokumentacja wszystkich endpointów
- ✅ Przykłady zapytań i odpowiedzi
- ✅ Interaktywne linki do testowania
- ✅ Opisy parametrów i kodów błędów
- ✅ Przykłady w JavaScript i PHP

This will:
- Start a MySQL 8.0 database container with the World database
- Start a PHP Apache web server container
- Automatically load the World database schema and data
- Make the application available at http://localhost:8080

3. Test the API endpoints:
- Countries: http://localhost:8080/api/read_countries.php
- Cities: http://localhost:8080/api/read_cities.php
- Single country: http://localhost:8080/api/read_single_country.php?id=1
- Create country: POST to http://localhost:8080/api/create_country.php

## Database Connection
- Host: db (internal Docker network)
- Database: world
- User: root
- Password: (empty)
- Port: 3306 (internal), 3306 (external)

## Stopping the Services
```bash
docker-compose down
```

To remove volumes as well:
```bash
docker-compose down -v
```