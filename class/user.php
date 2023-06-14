<?php
require_once 'database.php';

class User {
    private $conn;
    private $table_name = "user";

    public $id;
    public $login;
    public $password;

    public function __construct(){
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    // Method to register a user
    public function register($login, $password){
        try {
            $new_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO user(login,password) VALUES(:login,:password)");
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":password", $new_password);            
            $stmt->execute(); 
            return $stmt; 
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }    
    }

    // Method to login a user
    public function login($login, $password){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE login=:login LIMIT 1");
            $stmt->execute(array(':login'=>$login));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0) {
                if(password_verify($password, $userRow['password'])) {
                    $_SESSION['user_session'] = $userRow['id'];
                    return true;
                } else {
                    return false;
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Check if user is logged in
    public function is_loggedin(){
        if(isset($_SESSION['user_session'])) {
            return true;
        }
    }

    // Redirect
    public function redirect($url){
        header("Location: $url");
    }

    // Logout
    public function logout(){
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }

    // Update user's profile
    public function updateProfile($login, $password) {
        try {
            $new_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE user SET login=:login, password=:password WHERE id=:id");
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":password", $new_password);
            $stmt->bindParam(":id", $_SESSION['user_session']);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
?>
