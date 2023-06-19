<?php
// Including the classes for the database connection and the user.
require_once 'database.php';
require_once 'user.php';

// The Comment class handles operations related to comments.
class Comment {
    private $conn; // This will hold the database connection.
    private $table_name = "comment"; // The name of the comments table in the database.
    private $user; // The user object, which will handle user-related operations.

    // This is the class constructor. It initializes the database connection and the user object.
    public function __construct() {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
        $this->user = new User();
    }

    // Checks if a user is logged in.
    public function isUserLoggedIn() {
        return $this->user->is_loggedin();
    }

    // Redirects the user to a different page.
    public function redirectUser($location) {
        $this->user->redirect($location);
    }

    // Handles the HTTP POST requests. If a new comment is posted, it adds it. If a comment deletion is requested, it deletes the comment.
    public function handleRequest() {
        // If the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // If the new_comment field is set in the request
            if (isset($_POST['new_comment'])) {
                $content = $_POST['content'];
                $this->addComment($content, $_SESSION['user_session']);
            } elseif (isset($_POST['delete_comment'])) { // If the delete_comment field is set in the request
                $commentId = $_POST['comment_id'];
                $this->deleteComment($commentId, $_SESSION['user_session']);
            }
            // Refresh the page
            header('Location: '.$_SERVER['REQUEST_URI']);
            exit;
        }
    }

    // Adds a comment to the database.
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

    // Deletes a comment from the database.
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

    // Fetches all the comments from the database.
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
