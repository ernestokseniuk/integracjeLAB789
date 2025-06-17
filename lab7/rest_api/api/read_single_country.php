<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// Include database and object files
include_once '../config/Database.php';
include_once '../models/Country.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare country object
$country = new Country($db);

// Get country code from query parameter
$country->code = isset($_GET['code']) ? $_GET['code'] : die();

// Get the country
$country->read_single();

if($country->name != null) {
    // Create array
    $country_arr = array(
        "code" => $country->code,
        "name" => $country->name,
        "continent" => $country->continent,
        "region" => $country->region,
        "surface_area" => $country->surface_area,
        "indep_year" => $country->indep_year,
        "population" => $country->population,
        "life_expectancy" => $country->life_expectancy,
        "gnp" => $country->gnp,
        "gnp_old" => $country->gnp_old,
        "local_name" => $country->local_name,
        "government_form" => $country->government_form,
        "head_of_state" => $country->head_of_state,
        "capital" => $country->capital,
        "code2" => $country->code2
    );
    
    // Set response code - 200 OK
    http_response_code(200);
    
    // Make it json format
    echo json_encode($country_arr);
}
else {
    // Set response code - 404 Not found
    http_response_code(404);
    
    // Tell the user country does not exist
    echo json_encode(array("message" => "Country does not exist."));
}
?>