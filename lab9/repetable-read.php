<?php
// Przykład poziomu izolacji REPEATABLE READ
$servername = "db";  // Docker service name
$username = "sakila1";
$password = "pass";
$database = "sakila";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

echo "Database connected successfully, username " . $username . "<br><br>";

// Nie zmieniaj domyślnego poziomu izolacji REPEATABLE READ
// Rozpocznij transakcję
$conn->begin_transaction();

echo "<h3>Test poziomu izolacji REPEATABLE READ</h3>";
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

// Aby przetestować jak działa poziom izolacji, powinieneś wywołać update-adam.php w tym momencie,
// aby stan bazy danych został zmieniony
sleep(20);

// Powinieneś zobaczyć ten sam wynik zapytania nawet pomimo tego, że stan tabeli actor został zmieniony
// wynika to z poziomu izolacji REPEATABLE READ
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
echo "W poziomie izolacji REPEATABLE READ transakcja widzi spójny obraz danych przez cały czas trwania.<br>";
echo "Dlatego wyniki przed i po sleep powinny być identyczne, nawet jeśli inne transakcje zmodyfikowały dane.<br>";

// Zakończ transakcję
$conn->commit();
$conn->close();
?>

<br><br>
<a href="index1.php">Powrót do menu głównego</a>