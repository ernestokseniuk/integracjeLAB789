<?php
// Przykład aktualizacji tabeli actor - wszystkie imiona CHRIS będą zmienione na ADAM
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "db";  // Docker service name
$username = "sakila2";
$password = "pass";
$database = "sakila";

echo "<h3>Łączenie z bazą danych...</h3>";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

echo "Database connected successfully, username " . $username . "<br><br>";

$sql = "UPDATE actor SET first_name = 'ADAM' WHERE first_name = 'CHRIS'";
$result = $conn->query($sql);

if ($result) {
    echo "Table actor updated successfully<br>";
    echo "Affected rows: " . $conn->affected_rows . "<br>";
} else {
    echo "Error updating table: " . $conn->error . "<br>";
}

// Pokaż aktualny stan aktorów ADAM
echo "<br><strong>Aktualny stan aktorów o imieniu ADAM:</strong><br>";
$sql_select = "SELECT actor_id, first_name, last_name FROM actor WHERE first_name = 'ADAM'";
$result_select = $conn->query($sql_select);

if ($result_select->num_rows > 0) {
    while($row = $result_select->fetch_assoc()) {
        echo "id: " . $row["actor_id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
    }
} else {
    echo "0 results<br>";
}

$conn->close();
?>

<br><br>
<a href="index1.php">Powrót do menu głównego</a>