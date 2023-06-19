<?php
// Include the Database class
require_once 'database.php';

// Define the User class
class User {
    private $conn; // This will hold our database connection
    private $table_name = "user"; // This is the name of our table

    // These will hold the properties of our User
    public $id;
    public $login;
    public $password;

    // User class constructor
    public function __construct(){
        // Create a new database object
        $database = new Database();

        // Get a database connection
        $db = $database->dbConnection();

        // Set our database connection property
        $this->conn = $db;
    }

    // Method for registering a new user
    public function register($login, $password){
        try {
            // Hash the password for security
            $new_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare our SQL statement
            $stmt = $this->conn->prepare("INSERT INTO user(login,password) VALUES(:login,:password)");

            // Bind the parameters to the SQL query
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":password", $new_password);            

            // Execute the query
            $stmt->execute(); 

            // Return the prepared statement
            return $stmt; 
        }
        // Catch any errors
        catch(PDOException $e) {
            echo $e->getMessage();
        }    
    }

    // Method for user login
    public function login($login, $password){
        try {
            // Prepare our SQL statement
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE login=:login LIMIT 1");

            // Execute the query with the provided login
            $stmt->execute(array(':login'=>$login));

            // Fetch the user's data
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

            // If a user is found and the password matches, log them in
            if($stmt->rowCount() > 0) {
                if(password_verify($password, $userRow['password'])) {
                    $_SESSION['user_session'] = $userRow['id'];
                    return true;
                } else {
                    return false;
                }
            }
        }
        // Catch any errors
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Check if the user is logged in
    public function is_loggedin(){
        if(isset($_SESSION['user_session'])) {
            return true;
        }
    }

    // Redirect the user to another URL
    public function redirect($url){
        header("Location: $url");
    }

    // Logout the user
    public function logout(){
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }

    // Update the user's profile
    public function updateProfile($login, $password) {
        try {
            // Hash the new password
            $new_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement
            $stmt = $this->conn->prepare("UPDATE user SET login=:login, password=:password WHERE id=:id");

            // Bind the parameters
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":password", $new_password);
            $stmt->bindParam(":id", $_SESSION['user_session']);

            // Execute the query
            $stmt->execute();
            
            // Return true upon success
            return true;
        }
        // Catch any errors
        catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
?>
