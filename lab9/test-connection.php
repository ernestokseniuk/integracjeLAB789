<?php
// Test połączenia z bazą danych
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test połączenia z bazą danych Sakila</h2>";

$servername = "db";
$username = "sakila1";
$password = "pass";
$database = "sakila";

echo "<h3>1. Test połączenia z bazą danych</h3>";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("❌ Błąd połączenia: " . $conn->connect_error . "<br>");
}
echo "✅ Połączenie z bazą danych udane!<br><br>";

echo "<h3>2. Test rozszerzenia mysqli</h3>";
if (extension_loaded('mysqli')) {
    echo "✅ Rozszerzenie mysqli jest załadowane<br><br>";
} else {
    echo "❌ Rozszerzenie mysqli NIE jest załadowane<br><br>";
}

echo "<h3>3. Sprawdzenie czy baza sakila istnieje</h3>";
$result = $conn->query("SELECT DATABASE()");
if ($result) {
    $row = $result->fetch_row();
    echo "✅ Aktualnie połączona baza: " . $row[0] . "<br><br>";
} else {
    echo "❌ Błąd sprawdzania bazy: " . $conn->error . "<br><br>";
}

echo "<h3>4. Sprawdzenie tabel w bazie</h3>";
$result = $conn->query("SHOW TABLES");
if ($result) {
    $tables = [];
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
    if (in_array('actor', $tables)) {
        echo "✅ Tabela 'actor' istnieje<br>";
    } else {
        echo "❌ Tabela 'actor' NIE istnieje<br>";
    }
    echo "📋 Wszystkie tabele: " . implode(', ', $tables) . "<br><br>";
} else {
    echo "❌ Błąd pobierania listy tabel: " . $conn->error . "<br><br>";
}

echo "<h3>5. Test zapytania do tabeli actor</h3>";
$result = $conn->query("SELECT COUNT(*) as total FROM actor");
if ($result) {
    $row = $result->fetch_assoc();
    echo "✅ Liczba aktorów w tabeli: " . $row['total'] . "<br><br>";
} else {
    echo "❌ Błąd zapytania do tabeli actor: " . $conn->error . "<br><br>";
}

echo "<h3>6. Sprawdzenie aktorów o imieniu ADAM</h3>";
$result = $conn->query("SELECT actor_id, first_name, last_name FROM actor WHERE first_name = 'ADAM'");
if ($result) {
    if ($result->num_rows > 0) {
        echo "✅ Znaleziono " . $result->num_rows . " aktorów o imieniu ADAM:<br>";
        while($row = $result->fetch_assoc()) {
            echo "- ID: " . $row["actor_id"] . ", Imię: " . $row["first_name"] . ", Nazwisko: " . $row["last_name"] . "<br>";
        }
    } else {
        echo "⚠️ Brak aktorów o imieniu ADAM<br>";
        echo "Spróbujmy znaleźć jakichkolwiek aktorów:<br>";
        
        $all_result = $conn->query("SELECT actor_id, first_name, last_name FROM actor LIMIT 5");
        if ($all_result && $all_result->num_rows > 0) {
            echo "📋 Przykładowi aktorzy w bazie:<br>";
            while($row = $all_result->fetch_assoc()) {
                echo "- ID: " . $row["actor_id"] . ", Imię: " . $row["first_name"] . ", Nazwisko: " . $row["last_name"] . "<br>";
            }
        }
    }
    echo "<br>";
} else {
    echo "❌ Błąd zapytania o aktorów ADAM: " . $conn->error . "<br><br>";
}

echo "<h3>7. Test użytkownika sakila2</h3>";
$conn2 = new mysqli($servername, "sakila2", $password, $database);
if ($conn2->connect_error) {
    echo "❌ Błąd połączenia dla sakila2: " . $conn2->connect_error . "<br>";
} else {
    echo "✅ Połączenie dla użytkownika sakila2 udane!<br>";
    $conn2->close();
}

$conn->close();
?>

<br><br>
<a href="index1.php">Powrót do menu głównego</a>
