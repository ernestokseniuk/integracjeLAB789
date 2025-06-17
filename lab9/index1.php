<?php
// Główna strona aplikacji do testowania poziomów izolacji transakcji
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorium 9 - Poziomy izolacji transakcji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .section {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .section h3 {
            color: #555;
            margin-top: 0;
        }
        .link-list {
            list-style-type: none;
            padding: 0;
        }
        .link-list li {
            margin: 10px 0;
        }
        .link-list a {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .link-list a:hover {
            background-color: #0056b3;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laboratorium 9 - Testowanie poziomów izolacji transakcji</h1>
        
        <div class="info">
            <strong>Cel laboratorium:</strong> Przedstawienie podstawowych problemów wynikających z wielowątkowego dostępu do współdzielonych zasobów oraz testowanie poziomów izolacji w bazach danych.
        </div>        <div class="section">
            <h3>1. Diagnostyka</h3>
            <ul class="link-list">
                <li><a href="test-connection.php" target="_blank">🔧 Test połączenia z bazą danych</a></li>
            </ul>
        </div>

        <div class="section">
            <h3>2. Operacje na danych</h3>
            <ul class="link-list">
                <li><a href="select-adam.php" target="_blank">Sprawdź aktualny stan aktorów ADAM</a></li>
                <li><a href="update-chris.php" target="_blank">Aktualizuj CHRIS na ADAM</a></li>
                <li><a href="update-adam.php" target="_blank">Aktualizuj ADAM na CHRIS</a></li>
            </ul>
        </div>        <div class="section">
            <h3>3. Testy poziomów izolacji</h3>
            <div class="warning">
                <strong>Uwaga!</strong> Wykonuj testy w określonej kolejności zgodnie z instrukcją laboratorium.
            </div>
            <ul class="link-list">
                <li><a href="repetable-read.php" target="_blank">Test REPEATABLE READ</a></li>
                <li><a href="read-committed.php" target="_blank">Test READ COMMITTED</a></li>
            </ul>
        </div>        <div class="section">
            <h3>4. Zadania zaawansowane</h3>
            <ul class="link-list">
                <li><a href="dirty-read-test.php" target="_blank">Test Dirty Read</a></li>
                <li><a href="phantom-read-test.php" target="_blank">Test Phantom Read</a></li>
                <li><a href="serializable-test.php" target="_blank">Test SERIALIZABLE</a></li>
            </ul>
        </div>

        <div class="section">
            <h3>Instrukcja testowania</h3>
            <ol>
                <li>Upewnij się, że serwer XAMPP jest uruchomiony</li>
                <li>Sprawdź aktualny stan bazy danych</li>
                <li>Otwórz test w nowej karcie przeglądarki</li>
                <li>W trakcie 20-sekundowej przerwy wykonaj operację aktualizacji</li>
                <li>Obserwuj różnice w wynikach</li>
            </ol>
        </div>
    </div>
</body>
</html>