<?php
session_start();
require_once '../class/comment.php';

$comment = new Comment();

if (!$comment->isUserLoggedIn()) {
    $comment->redirectUser('login.php');
}

$comment->handleRequest();

$comments = $comment->getComments();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Livre d'or</title>
    <link rel="stylesheet" href="../CSS/golden-book.css">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <h1 class="nav-title">Livre d'or</h1>
            <div class="nav-links">
                <a href="../index.php" class="nav-link">Accueil</a>
                <a href="logout.php" class="nav-link">Déconnexion</a>
            </div>
        </div>
    </div>
    <form method="POST">
        <textarea name="content" required></textarea>
        <input type="submit" name="new_comment" value="Ajouter un commentaire">
    </form>
    <?php foreach ($comments as $commentData): ?>
        <div class="comment">
            <div class="comment-wrapper">
                <p>Posté le <?php echo htmlspecialchars($commentData['date']); ?> par <?php echo htmlspecialchars($commentData['username']); ?></p>
                <div class="comment-content">
                    <p><?php echo htmlspecialchars($commentData['comment']); ?></p>
                </div>
                <?php if ($commentData['id_user'] === $_SESSION['user_session']): ?>
                    <form method="POST" class="form-delete-button">
                        <input type="hidden" name="comment_id" value="<?php echo $commentData['id']; ?>">
                        <input type="submit" name="delete_comment" value="Supprimer" class="delete-button">
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
