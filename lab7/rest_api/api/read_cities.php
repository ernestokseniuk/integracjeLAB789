<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../config/Database.php';
include_once '../models/City.php';

// Instantiate database and city object
$database = new Database();
$db = $database->getConnection();

// Initialize city object
$city = new City($db);

// Check if country parameter is provided
$country_code = isset($_GET['country']) ? $_GET['country'] : null;

// Query cities
if($country_code) {
    $stmt = $city->read_by_country($country_code);
} else {
    $stmt = $city->read();
}

// Check if more than 0 records found
if($stmt->num_rows > 0) {
    
    // Cities array
    $cities_arr = array();
    $cities_arr["records"] = array();
    
    // Retrieve table contents
    while ($row = $stmt->fetch_assoc()) {
        // Extract row
        $city_item = array(
            "id" => $row['ID'],
            "name" => $row['Name'],
            "country_code" => $row['CountryCode'],
            "district" => $row['District'],
            "population" => $row['Population']
        );
        
        array_push($cities_arr["records"], $city_item);
    }
    
    // Set response code - 200 OK
    http_response_code(200);
    
    // Show cities data in json format
    echo json_encode($cities_arr);
    
} else {
    
    // Set response code - 404 Not found
    http_response_code(404);
    
    // Tell the user no cities found
    $message = $country_code ? "No cities found for country: " . $country_code : "No cities found.";
    echo json_encode(
        array("message" => $message)
    );
}
?>