<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object files
include_once '../config/Database.php';
include_once '../models/Country.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Instantiate country object
$country = new Country($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Make sure data is not empty - check properties exist and are not empty strings
if(
    isset($data->code) && trim($data->code) !== '' &&
    isset($data->name) && trim($data->name) !== '' &&
    isset($data->continent) && trim($data->continent) !== '' &&
    isset($data->region) && trim($data->region) !== '' &&
    isset($data->surface_area) && is_numeric($data->surface_area) &&
    isset($data->population) && is_numeric($data->population) &&
    isset($data->local_name) && trim($data->local_name) !== '' &&
    isset($data->government_form) && trim($data->government_form) !== '' &&
    isset($data->code2) && trim($data->code2) !== ''
) {
      // Set country property values
    $country->code = $data->code;
    $country->name = $data->name;
    $country->continent = $data->continent;
    $country->region = $data->region;
    $country->surface_area = $data->surface_area;
    $country->indep_year = isset($data->indep_year) ? $data->indep_year : null;
    $country->population = $data->population;
    $country->life_expectancy = isset($data->life_expectancy) ? $data->life_expectancy : null;
    $country->gnp = isset($data->gnp) ? $data->gnp : null;
    $country->gnp_old = isset($data->gnp_old) ? $data->gnp_old : null;
    $country->local_name = $data->local_name;
    $country->government_form = $data->government_form;
    $country->head_of_state = isset($data->head_of_state) ? $data->head_of_state : null;
    $country->capital = isset($data->capital) ? $data->capital : null;
    $country->code2 = $data->code2;
    
    // Create the country
    if($country->create()) {
        
        // Set response code - 201 created
        http_response_code(201);
        
        // Tell the user
        echo json_encode(array("message" => "Country was created."));
    }
    
    // If unable to create the country, tell the user
    else {
        
        // Set response code - 503 service unavailable
        http_response_code(503);
        
        // Tell the user
        echo json_encode(array("message" => "Unable to create country."));
    }
}

// Tell the user data is incomplete
else {
    
    // Check which fields are missing
    $missing_fields = [];
    if(!isset($data->code) || trim($data->code) === '') $missing_fields[] = 'code';
    if(!isset($data->name) || trim($data->name) === '') $missing_fields[] = 'name';
    if(!isset($data->continent) || trim($data->continent) === '') $missing_fields[] = 'continent';
    if(!isset($data->region) || trim($data->region) === '') $missing_fields[] = 'region';
    if(!isset($data->surface_area) || !is_numeric($data->surface_area)) $missing_fields[] = 'surface_area';
    if(!isset($data->population) || !is_numeric($data->population)) $missing_fields[] = 'population';
    if(!isset($data->local_name) || trim($data->local_name) === '') $missing_fields[] = 'local_name';
    if(!isset($data->government_form) || trim($data->government_form) === '') $missing_fields[] = 'government_form';
    if(!isset($data->code2) || trim($data->code2) === '') $missing_fields[] = 'code2';
    
    // Set response code - 400 bad request
    http_response_code(400);
      // Tell the user
    echo json_encode(array(
        "message" => "Unable to create country. Data is incomplete.",
        "missing_fields" => $missing_fields
    ));
}
?>