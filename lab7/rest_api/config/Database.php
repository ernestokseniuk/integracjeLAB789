<?php
class Database {
    // Database configuration
    private $host = "db";  // Changed to match Docker Compose service name
    private $database_name = "world";
    private $username = "root";
    private $password = "";
    
    public $conn;
    
    // Get database connection
    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database_name);
            
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
            
            // Set charset to utf8
            $this->conn->set_charset("utf8");
            
        } catch(Exception $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>
