# Konfiguracja Portów - Wszystkie Aplikacje

## Przegląd portów zewnętrznych

Wszystkie aplikacje mają skonfigurowane porty zewnętrzne umożliwiające dostęp z hosta:

### Lab 7 - REST API (PHP + MySQL)
- **MySQL Database**: `localhost:3306`
- **REST API (PHP)**: `http://localhost:8080`
- **Status**: ✅ Porty otwarte i skonfigurowane

### Lab 8 - ASP.NET Core API
- **ASP.NET Core API**: `http://localhost:8081`
- **Status**: ✅ Porty otwarte i skonfigurowane

### Lab 9 - PHP + MySQL (Sakila)
- **MySQL Database**: `localhost:3307`
- **PHP Web Application**: `http://localhost:8082`
- **Status**: ✅ Porty otwarte i skonfigurowane (zaktualizowane)

## Zmiany wykonane:

1. **Lab 9**: 
   - Poprawiono błąd składniowy w `docker-compose.yml`
   - Zmieniono port web z `8081` na `8082` (unikanie konfliktu z Lab 8)

2. **Lab 8**: 
   - Poprawiono błąd składniowy w `docker-compose.yml`
   - Poprawiono ścieżkę kontekstu buildu

## Instrukcje uruchomienia:

### Lab 7
```bash
cd lab7
docker-compose up -d
```
Dostęp: http://localhost:8080

### Lab 8
```bash
cd lab8
docker-compose up -d
```
Dostęp: http://localhost:8081

### Lab 9
```bash
cd lab9
docker-compose up -d
```
Dostęp: http://localhost:8082

## Unikalne porty:

- **3306** - MySQL Lab 7
- **3307** - MySQL Lab 9  
- **8080** - PHP REST API Lab 7
- **8081** - ASP.NET Core API Lab 8
- **8082** - PHP Web App Lab 9

Wszystkie porty są unikalne i nie powodują konfliktów.
