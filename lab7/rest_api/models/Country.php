<?php
class Country {
    // Database connection and table name
    private $conn;
    private $table_name = "country";
    
    // Object properties
    public $code;
    public $name;
    public $continent;
    public $region;
    public $surface_area;
    public $indep_year;
    public $population;
    public $life_expectancy;
    public $gnp;
    public $gnp_old;
    public $local_name;
    public $government_form;
    public $head_of_state;
    public $capital;
    public $code2;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Read all countries
    function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name";
        $result = $this->conn->query($query);
        return $result;
    }
    
    // Read single country
    function read_single() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE code = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->code);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if($row) {
            $this->name = $row['Name'];
            $this->continent = $row['Continent'];
            $this->region = $row['Region'];
            $this->surface_area = $row['SurfaceArea'];
            $this->indep_year = $row['IndepYear'];
            $this->population = $row['Population'];
            $this->life_expectancy = $row['LifeExpectancy'];
            $this->gnp = $row['GNP'];
            $this->gnp_old = $row['GNPOld'];
            $this->local_name = $row['LocalName'];
            $this->government_form = $row['GovernmentForm'];
            $this->head_of_state = $row['HeadOfState'];
            $this->capital = $row['Capital'];
            $this->code2 = $row['Code2'];
            return true;
        }
        return false;
    }
    
    // Create country
    function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET Code=?, Name=?, Continent=?, Region=?, SurfaceArea=?, 
                     IndepYear=?, Population=?, LifeExpectancy=?, GNP=?, 
                     GNPOld=?, LocalName=?, GovernmentForm=?, HeadOfState=?, 
                     Capital=?, Code2=?";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->continent = htmlspecialchars(strip_tags($this->continent));
        $this->region = htmlspecialchars(strip_tags($this->region));
        $this->local_name = htmlspecialchars(strip_tags($this->local_name));
        $this->government_form = htmlspecialchars(strip_tags($this->government_form));
        $this->head_of_state = htmlspecialchars(strip_tags($this->head_of_state));
        $this->code2 = htmlspecialchars(strip_tags($this->code2));
        
        $stmt->bind_param("ssssdidsddsssis", 
            $this->code, $this->name, $this->continent, $this->region, 
            $this->surface_area, $this->indep_year, $this->population, 
            $this->life_expectancy, $this->gnp, $this->gnp_old, 
            $this->local_name, $this->government_form, $this->head_of_state, 
            $this->capital, $this->code2);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Update country
    function update() {
        $query = "UPDATE " . $this->table_name . " 
                 SET Name=?, Continent=?, Region=?, SurfaceArea=?, 
                     IndepYear=?, Population=?, LifeExpectancy=?, GNP=?, 
                     GNPOld=?, LocalName=?, GovernmentForm=?, HeadOfState=?, 
                     Capital=?, Code2=?
                 WHERE Code=?";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->continent = htmlspecialchars(strip_tags($this->continent));
        $this->region = htmlspecialchars(strip_tags($this->region));
        $this->local_name = htmlspecialchars(strip_tags($this->local_name));
        $this->government_form = htmlspecialchars(strip_tags($this->government_form));
        $this->head_of_state = htmlspecialchars(strip_tags($this->head_of_state));
        $this->code2 = htmlspecialchars(strip_tags($this->code2));
        $this->code = htmlspecialchars(strip_tags($this->code));
        
        $stmt->bind_param("sssdidsddsssis", 
            $this->name, $this->continent, $this->region, 
            $this->surface_area, $this->indep_year, $this->population, 
            $this->life_expectancy, $this->gnp, $this->gnp_old, 
            $this->local_name, $this->government_form, $this->head_of_state, 
            $this->capital, $this->code2, $this->code);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Delete country
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE code = ?";
        $stmt = $this->conn->prepare($query);
        
        $this->code = htmlspecialchars(strip_tags($this->code));
        $stmt->bind_param("s", $this->code);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
