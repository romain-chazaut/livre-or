<?php
class Comment {
    private $id;
    private $comment;
    private $id_user;
    private $date;

    public function __construct($id, $comment, $id_user, $date) {
        $this->id = $id;
        $this->comment = $comment;
        $this->id_user = $id_user;
        $this->date = $date;
    }

    // Getter and Setter for id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter and Setter for comment
    public function getComment() {
        return $this->comment;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    // Getter and Setter for id_user
    public function getIdUser() {
        return $this->id_user;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    // Getter and Setter for date
    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    // Method to add a comment
    public function addComment($comment, $id_user) {
        // Implementation depends on your database
    }

    // Method to get all comments
    public function getComments() {
        // Implementation depends on your database
    }
}
?>
