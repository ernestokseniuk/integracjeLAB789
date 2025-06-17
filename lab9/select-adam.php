<?php
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

echo "<strong>Lista aktorów o imieniu ADAM:</strong><br>";
$sql = "SELECT actor_id, first_name, last_name FROM actor WHERE first_name = 'ADAM'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Znaleziono " . $result->num_rows . " aktorów:<br><br>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["actor_id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>

<br><br>
<a href="index1.php">Powrót do menu głównego</a>