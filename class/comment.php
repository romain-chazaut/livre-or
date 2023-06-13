<?php
require_once 'database.php';

class Comment {
    private $conn;
    private $table_name = "comment";

    public $id;
    public $comment;
    public $id_user;
    public $date;

    public function __construct() {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    // Method to add a comment
    public function addComment($comment, $id_user) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO comment(comment,id_user,date) VALUES(:comment,:id_user,NOW())");
            $stmt->bindParam(":comment", $comment);
            $stmt->bindParam(":id_user", $id_user);            
            $stmt->execute(); 
            return $stmt;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Method to get all comments
    public function getComments() {
        try {
            $stmt = $this->conn->prepare("SELECT comment.*, user.login AS username FROM comment JOIN user ON comment.id_user=user.id ORDER BY date DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>
