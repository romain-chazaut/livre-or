<?php
require_once 'database.php';
require_once 'user.php';

class Comment {
    private $conn;
    private $table_name = "comment";
    private $user;

    public $id;
    public $comment;
    public $id_user;
    public $date;

    public function __construct() {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
        $this->user = new User();
    }

    // Method to check if a user is logged in
    public function isUserLoggedIn() {
        return $this->user->is_loggedin();
    }

    // Method to redirect user
    public function redirectUser($location) {
        $this->user->redirect($location);
    }

    // Method to handle requests
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['new_comment'])) {
                $content = $_POST['content'];
                $this->addComment($content, $_SESSION['user_session']);
            } elseif (isset($_POST['delete_comment'])) {
                $commentId = $_POST['comment_id'];
                $this->deleteComment($commentId, $_SESSION['user_session']);
            }
            // Refresh the page
            header('Location: '.$_SERVER['REQUEST_URI']);
            exit;
        }
    }

    // Method to add a comment
    public function addComment($comment, $id_user) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO comment(comment, id_user, date) VALUES(:comment, :id_user, NOW())");
            $stmt->bindParam(":comment", $comment);
            $stmt->bindParam(":id_user", $id_user);
            $stmt->execute();
            return true;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // Method to delete a comment
    public function deleteComment($id, $id_user) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM comment WHERE id = :id AND id_user = :id_user");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":id_user", $id_user);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // Method to get all comments
    public function getComments() {
        try {
            $stmt = $this->conn->prepare("
                SELECT comment.*, user.login AS username 
                FROM comment 
                JOIN user ON comment.id_user=user.id 
                ORDER BY comment.date DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
?>
