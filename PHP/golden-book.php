<?php
// Start the session
session_start();

// Include the Comment class file
require_once '../class/comment.php';

// Create a new Comment object
$comment = new Comment();

// If the user isn't logged in, redirect them to the login page
if (!$comment->isUserLoggedIn()) {
    $comment->redirectUser('login.php');
}

// Handle the request (this checks for POST requests for new comments or deletion of existing comments)
$comment->handleRequest();

// Get all comments
$comments = $comment->getComments();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Livre d'or</title>
    <link rel="stylesheet" href="../CSS/golden-book.css"> <!-- Link the CSS stylesheet -->
</head>
<body>
    <div class="header">
        <div class="navbar">
            <h1 class="nav-title">Livre d'or</h1>
            <div class="nav-links">
                <a href="../index.php" class="nav-link">Profil</a> <!-- Link to the user's profile -->
                <a href="logout.php" class="nav-link">Déconnexion</a> <!-- Link to the logout page -->
            </div>
        </div>
    </div>
    <form method="POST"> <!-- Form to create a new comment -->
        <textarea name="content" required></textarea> <!-- Text area for the comment -->
        <input type="submit" name="new_comment" value="Ajouter un commentaire"> <!-- Submit button -->
    </form>
    <?php foreach ($comments as $commentData): ?> <!-- Loop over each comment -->
        <div class="comment">
            <div class="comment-wrapper">
                <p>Posté le <?php echo htmlspecialchars($commentData['date']); ?> par <?php echo htmlspecialchars($commentData['username']); ?></p> <!-- Show the comment date and username -->
                <div class="comment-content">
                    <p><?php echo htmlspecialchars($commentData['comment']); ?></p> <!-- Show the comment content -->
                </div>
                <?php if ($commentData['id_user'] === $_SESSION['user_session']): ?> <!-- If the logged in user is the one who posted this comment -->
                    <form method="POST" class="form-delete-button"> <!-- Form to delete a comment -->
                        <input type="hidden" name="comment_id" value="<?php echo $commentData['id']; ?>"> <!-- Hidden field to hold the comment id -->
                        <input type="submit" name="delete_comment" value="Supprimer" class="delete-button"> <!-- Submit button to delete the comment -->
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
