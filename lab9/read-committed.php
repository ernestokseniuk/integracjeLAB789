<?php
// Przykład poziomu izolacji READ COMMITTED (domyślny)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "db";  // Docker service name
$username = "sakila1";
$password = "pass";
$database = "sakila";

echo "<h3>Łączenie z bazą danych...</h3>";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

echo "Database connected successfully, username " . $username . "<br><br>";

// Sprawdzenie czy tabela actor istnieje
$check_table = $conn->query("SHOW TABLES LIKE 'actor'");
if ($check_table->num_rows == 0) {
    die("Tabela 'actor' nie istnieje w bazie danych!<br>");
}

// Zmień domyślny poziom izolacji (domyślny to REPEATABLE READ)
if (!$conn->query("SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED")) {
    die("Błąd ustawiania poziomu izolacji: " . $conn->error);
}

// Rozpocznij transakcję
$conn->begin_transaction();

echo "<h3>Test poziomu izolacji READ COMMITTED</h3>";
echo "<p><strong>PRZED SLEEP (20 sekund)</strong></p>";

$sql = "SELECT actor_id, first_name, last_name FROM actor WHERE first_name = 'ADAM'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Znaleziono " . $result->num_rows . " aktorów:<br>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["actor_id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
    }
} else {
    echo "0 results<br>";
}

echo "<br><strong>UWAGA:</strong> Teraz wykonaj aktualizację w innej karcie przeglądarki:<br>";
echo "<a href='update-adam.php' target='_blank'>update-adam.php</a><br>";
echo "Następnie sprawdź stan bazy: <a href='select-adam.php' target='_blank'>select-adam.php</a><br><br>";

// Aby przetestować jak działa poziom izolacji, powinieneś wywołać update-adam.php z drugiej aplikacji w tym momencie,
// aby stan bazy danych został zmieniony
sleep(20);

// Powinieneś zobaczyć inny wynik zapytania nawet pomimo tego, że oba zapytania są wykonywane podczas jednej transakcji.
// Wynika to ze zmienionego poziomu izolacji, który pozwala na odczyt zatwierdzonych zmian z innych transakcji
echo "<p><strong>PO SLEEP (20 sekund)</strong></p>";
$sql = "SELECT actor_id, first_name, last_name FROM actor WHERE first_name = 'ADAM'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Znaleziono " . $result->num_rows . " aktorów:<br>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["actor_id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
    }
} else {
    echo "0 results<br>";
}

echo "<br><strong>WYJAŚNIENIE:</strong><br>";
echo "W poziomie izolacji READ COMMITTED transakcja może odczytać zmiany zatwierdzone przez inne transakcje.<br>";
echo "Dlatego wyniki przed i po sleep mogą się różnić.<br>";

$conn->commit();
$conn->close();
?>

<br><br>
<a href="index1.php">Powrót do menu głównego</a>