<?php
class City {
    // Database connection and table name
    private $conn;
    private $table_name = "city";
    
    // Object properties
    public $id;
    public $name;
    public $country_code;
    public $district;
    public $population;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Read all cities
    function read() {
        $query = "SELECT c.ID, c.Name, c.CountryCode, c.District, c.Population, co.Name as CountryName 
                 FROM " . $this->table_name . " c
                 LEFT JOIN country co ON c.CountryCode = co.Code
                 ORDER BY c.Name";
        $result = $this->conn->query($query);
        return $result;
    }
    
    // Read cities by country
    function read_by_country($country_code) {
        $query = "SELECT c.ID, c.Name, c.CountryCode, c.District, c.Population, co.Name as CountryName 
                 FROM " . $this->table_name . " c
                 LEFT JOIN country co ON c.CountryCode = co.Code
                 WHERE c.CountryCode = ?
                 ORDER BY c.Population DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $country_code);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    // Read single city
    function read_single() {
        $query = "SELECT c.ID, c.Name, c.CountryCode, c.District, c.Population, co.Name as CountryName 
                 FROM " . $this->table_name . " c
                 LEFT JOIN country co ON c.CountryCode = co.Code
                 WHERE c.ID = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if($row) {
            $this->name = $row['Name'];
            $this->country_code = $row['CountryCode'];
            $this->district = $row['District'];
            $this->population = $row['Population'];
            return true;
        }
        return false;
    }
    
    // Create city
    function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET Name=?, CountryCode=?, District=?, Population=?";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->country_code = htmlspecialchars(strip_tags($this->country_code));
        $this->district = htmlspecialchars(strip_tags($this->district));
        
        $stmt->bind_param("sssi", $this->name, $this->country_code, $this->district, $this->population);
        
        if($stmt->execute()) {
            $this->id = $this->conn->insert_id;
            return true;
        }
        return false;
    }
    
    // Update city
    function update() {
        $query = "UPDATE " . $this->table_name . " 
                 SET Name=?, CountryCode=?, District=?, Population=?
                 WHERE ID=?";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->country_code = htmlspecialchars(strip_tags($this->country_code));
        $this->district = htmlspecialchars(strip_tags($this->district));
        
        $stmt->bind_param("sssii", $this->name, $this->country_code, $this->district, $this->population, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Delete city
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID = ?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("i", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
