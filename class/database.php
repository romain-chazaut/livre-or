<?php
// The Database class is responsible for creating a connection to the database.
class Database {
    private $host = "localhost"; 
    private $db_name = "livreor"; 
    private $username = "root"; 
    private $password = "Romain-1964";
    public $conn; 

    // This function tries to establish a connection to the database and returns the connection.
    public function dbConnection() {
        $this->conn = null; // Initially, the connection is null.
        try {
            // Try to connect to the database using the host, dbname, username and password.
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // If the connection is successful, set the error mode to exception mode. 
            // This means that if there is an error, a PDOException will be thrown.
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            // If there is an error, the error message is displayed.
            echo "Connection error: " . $exception->getMessage();
        }
        // The connection is returned.
        return $this->conn;
    }
}
?>
