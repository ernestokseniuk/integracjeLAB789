# Lab 9 - Transaction Isolation Levels with Sakila Database

This lab demonstrates different transaction isolation levels using the Sakila database.

## Requirements
- Docker
- Docker Compose

## Setup and Running

1. Navigate to the lab9 directory:
```bash
cd lab9
```

2. Start the services using Docker Compose:
```bash
docker-compose up -d
```

This will:
- Start a MySQL 8.0 database container with the Sakila database
- Start a PHP Apache web server container
- Automatically load the Sakila database schema and data
- Create users: sakila1 and sakila2 (both with password: pass)
- Make the application available at http://localhost:8081

3. Access the application:
- Main menu: http://localhost:8081/index1.php
- Diagnostics: http://localhost:8081/test-connection.php
- READ COMMITTED test: http://localhost:8081/read-committed.php
- REPEATABLE READ test: http://localhost:8081/repetable-read.php

## Database Connection
- Host: db (internal Docker network)
- Database: sakila
- Users: sakila1, sakila2
- Password: pass
- Root password: rootpass
- Port: 3306 (internal), 3307 (external)

## Testing Transaction Isolation

The lab includes several test scripts:
- `read-committed.php` - Tests READ COMMITTED isolation level
- `repetable-read.php` - Tests REPEATABLE READ isolation level
- `update-adam.php` - Updates actor names from ADAM to CHRIS
- `update-chris.php` - Updates actor names from CHRIS to ADAM
- `select-adam.php` - Queries actors with name ADAM

## How to Test

1. Open multiple browser tabs
2. Start a transaction test (e.g., read-committed.php)
3. During the 20-second sleep, run update scripts in other tabs
4. Observe how different isolation levels affect the results

## Stopping the Services
```bash
docker-compose down
```

To remove volumes as well:
```bash
docker-compose down -v
```
