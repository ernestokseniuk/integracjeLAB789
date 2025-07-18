# 🧪 Laboratoria Integracji Systemów

Kompletny zestaw projektów laboratoryjnych demonstrujących różne aspekty integracji systemów informatycznych.

## 📁 Struktura Projektów

### Lab 7 - REST API z bazą danych World
- **Technologie:** PHP, MySQL, Docker
- **Port:** 8000
- **Opis:** REST API do zarządzania krajami i miastami

### Lab 8 - Autoryzacja JWT
- **Technologie:** .NET Core, JWT, C#
- **Port:** 8081 
- **Opis:** API z autoryzacją opartą na rolach

### Lab 9 - Poziomy izolacji transakcji
- **Technologie:** PHP, MySQL, Docker, baza Sakila
- **Port:** 8080
- **Opis:** Demonstracja poziomów izolacji transakcji w MySQL

## 🚀 Szybki Start

### Automatyczne uruchomienie wszystkich projektów:
```powershell
# Uruchom wszystkie dostępne projekty
.\start_all_labs.ps1

# Zatrzymaj wszystkie projekty
.\stop_all_labs.ps1
```

### Manualne uruchomienie:

#### Lab 7:
```bash
cd lab7
docker-compose up -d
# API: http://localhost:8080
```

#### Lab 8:
```bash
cd lab8/lab8/lab8
dotnet run
# API: http://localhost:8080
```

#### Lab 9:
```bash
cd lab9
docker-compose up -d
# Aplikacja: http://localhost:8081
```

## 📊 Testowanie z Postman

1. **Importuj kolekcję:** `Postman_Collection_Labs.json`
2. **Przeczytaj instrukcje:** `README_Postman.md`
3. **Testuj endpointy** zgodnie z dokumentacją

### Struktura kolekcji Postman:
- **Lab 7:** CRUD operacje na krajach i miastach
- **Lab 8:** Autoryzacja JWT z różnymi rolami użytkowników
- **Lab 9:** Operacje demonstrujące poziomy izolacji transakcji

## 📋 Pliki w Projekcie

```
├── Postman_Collection_Labs.json      # ← Kolekcja Postman
├── README_Postman.md                 # ← Instrukcje Postman
├── start_all_labs.ps1               # ← Skrypt uruchamiający
├── stop_all_labs.ps1                # ← Skrypt zatrzymujący
├── polecenie.txt
├── README.md
├── lab7/                            # REST API World Database
│   ├── docker-compose.yml
│   ├── README.md
│   ├── db_dumps/
│   │   └── world.sql
│   └── rest_api/
│       ├── Dockerfile
│       ├── index.php
│       ├── api/
│       │   ├── create_country.php
│       │   ├── read_cities.php
│       │   ├── read_countries.php
│       │   └── read_single_country.php
│       ├── config/
│       │   └── Database.php
│       └── models/
│           ├── City.php
│           └── Country.php
├── lab8/                            # JWT Authentication API
│   └── lab8/
│       ├── co_zrobic.txt
│       ├── lab8.sln
│       ├── ApiClient/              # Windows Forms client
│       │   ├── Form1.cs
│       │   ├── Form1.Designer.cs
│       │   └── Models/
│       │       ├── AuthRequest.cs
│       │       ├── AuthResponse.cs
│       │       └── User.cs
│       └── lab8/                   # Web API project
│           ├── appsettings.json
│           ├── lab8.csproj
│           ├── Program.cs
│           ├── Controllers/
│           │   ├── NumbersController.cs
│           │   └── UsersController.cs
│           ├── Entities/
│           │   ├── Role.cs
│           │   └── User.cs
│           ├── Model/
│           │   ├── AuthenticationRequest.cs
│           │   └── AuthenticationResponse.cs
│           └── Services/
│               └── Users/
│                   ├── IUserService.cs
│                   └── UserServiceImpl.cs
├── lab9/                            # Transaction Isolation Demo
│   ├── docker-compose.yml
│   ├── index1.php
│   ├── init-users.sql
│   ├── read-committed.php
│   ├── README.md
│   ├── repetable-read.php
│   ├── select-adam.php
│   ├── update-adam.php
│   └── update-chris.php
├── sakila-db/                       # Sakila database files
│   └── sakila-db/
│       ├── sakila-data.sql
│       ├── sakila-schema.sql
│       └── sakila.mwb
└── world-db/                        # World database files
    └── world.sql
```

## 🧪 Szczegółowe Instrukcje Testowania

### Lab 7 - REST API World Database

**Endpointy do testowania:**
- `GET /api/read_countries.php` - Lista wszystkich krajów
- `GET /api/read_cities.php` - Lista wszystkich miast  
- `GET /api/read_single_country.php?id=POL` - Szczegóły kraju
- `POST /api/create_country.php` - Utworzenie nowego kraju

**Przykładowe dane JSON:**
```json
{
    "code": "TST",
    "name": "Test Country",
    "continent": "Europe",
    "region": "Northern Europe",
    "surface_area": 1000.50,
    "population": 1000000
}
```

### Lab 8 - JWT Authentication API

**Użytkownicy testowi:**
- **Andrzej/Andrzej** - Role: `admin`, `user`
- **Piotrek/Piotrek** - Role: `number`, `user`  
- **Ania/Ania** - Role: `user`

**Scenariusz testowy:**
1. Zaloguj się jako Andrzej → Token JWT
2. Testuj endpoint `/api/users` (wymaga roli `admin`) ✅
3. Testuj endpoint `/api/numbers/random-prime` (wymaga roli `number`) ❌
4. Zaloguj się jako Piotrek → Nowy token
5. Testuj endpoint `/api/numbers/random-prime` ✅
6. Testuj endpoint `/api/users` ❌

### Lab 9 - Transaction Isolation Demo

**Scenariusz testowy READ COMMITTED:**
1. Otwórz: `http://localhost:8081/read-committed.php`
2. Strona czeka 20 sekund po pierwszym zapytaniu
3. W tym czasie otwórz nową kartę: `update-adam.php`
4. Wróć do pierwszej karty - zobacz różnicę w wynikach

**Scenariusz testowy REPEATABLE READ:**
1. Otwórz: `http://localhost:8081/repetable-read.php`
2. Strona czeka 20 sekund po pierwszym zapytaniu  
3. W tym czasie otwórz nową kartę: `update-adam.php`
4. Wróć do pierwszej karty - wyniki powinny być identyczne

## 🔧 Troubleshooting

### Porty zajęte
```powershell
# Sprawdź co używa portu 8080
netstat -ano | findstr :8080

# Zatrzymaj wszystkie Docker kontenery
docker stop $(docker ps -q)
```

### Lab 8 nie uruchamia się
```bash
cd lab8/lab8/lab8
dotnet restore
dotnet build
dotnet run
```

### Problemy z Docker
```bash
# Restart Docker Desktop
# Lub wyczyść wszystko i zacznij od nowa
docker system prune -a --volumes
```

## 📞 Pomoc

W przypadku problemów:
1. Sprawdź, czy wszystkie kontenery/aplikacje są uruchomione
2. Sprawdź logi aplikacji  
3. Upewnij się, że porty nie są zajęte
4. Przeczytaj dokumentację w folderach poszczególnych labs

---

**Powodzenia w testowaniu!** 🎉
#   i n t e g r a c j e L A B 7 8 9 
 
 