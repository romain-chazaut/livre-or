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
        <h1 class="header-title">Livre d'or</h1>
        <div class="navbar">
            <a href="../index.php" class="nav-link">Accueil</a>
            <a href="logout.php" class="nav-link">Déconnexion</a>
        </div>
    </div>
    <form method="POST">
        <textarea name="content" required></textarea>
        <input type="submit" name="new_comment" value="Ajouter un commentaire">
    </form>
    <?php foreach ($comments as $commentData): ?>
        <div class="comment">
            <p>Posté le <?php echo htmlspecialchars($commentData['date']); ?> par <?php echo htmlspecialchars($commentData['username']); ?></p>
            <div class="comment-content">
                <p><?php echo htmlspecialchars($commentData['comment']); ?></p>
            </div>
            <?php if ($commentData['id_user'] === $_SESSION['user_session']): ?>
                <form method="POST">
                    <input type="hidden" name="comment_id" value="<?php echo $commentData['id']; ?>">
                    <input type="submit" name="delete_comment" value="Supprimer" class="delete-button">
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>

