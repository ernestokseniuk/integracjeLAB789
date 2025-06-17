<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../config/Database.php';
include_once '../models/Country.php';

// Instantiate database and country object
$database = new Database();
$db = $database->getConnection();

// Initialize country object
$country = new Country($db);

// Query countries
$stmt = $country->read();

// Check if more than 0 records found
if($stmt->num_rows > 0) {
    
    // Countries array
    $countries_arr = array();
    $countries_arr["records"] = array();
    
    // Retrieve table contents
    while ($row = $stmt->fetch_assoc()) {
        // Extract row
        $country_item = array(
            "code" => $row['Code'],
            "name" => $row['Name'],
            "continent" => $row['Continent'],
            "region" => $row['Region'],
            "surface_area" => $row['SurfaceArea'],
            "indep_year" => $row['IndepYear'],
            "population" => $row['Population'],
            "life_expectancy" => $row['LifeExpectancy'],
            "gnp" => $row['GNP'],
            "gnp_old" => $row['GNPOld'],
            "local_name" => $row['LocalName'],
            "government_form" => $row['GovernmentForm'],
            "head_of_state" => $row['HeadOfState'],
            "capital" => $row['Capital'],
            "code2" => $row['Code2']
        );
        
        array_push($countries_arr["records"], $country_item);
    }
    
    // Set response code - 200 OK
    http_response_code(200);
    
    // Show countries data in json format
    echo json_encode($countries_arr);
    
} else {
    
    // Set response code - 404 Not found
    http_response_code(404);
    
    // Tell the user no countries found
    echo json_encode(
        array("message" => "No countries found.")
    );
}
?>