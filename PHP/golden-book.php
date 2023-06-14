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
    <style>
        .comment {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        .comment p {
            margin: 0;
        }
    </style>
</head>
<body>
    <h1>Livre d'or</h1>
    <?php foreach ($comments as $commentData): ?>
        <div class="comment">
            <p>Posté le <?php echo htmlspecialchars($commentData['date']); ?> par <?php echo htmlspecialchars($commentData['username']); ?></p>
            <p><?php echo htmlspecialchars($commentData['comment']); ?></p>
            <?php if ($commentData['id_user'] === $_SESSION['user_session']): ?>
                <form method="POST">
                    <input type="hidden" name="comment_id" value="<?php echo $commentData['id']; ?>">
                    <input type="submit" name="delete_comment" value="Supprimer">
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <form method="POST">
        <textarea name="content" required></textarea>
        <input type="submit" name="new_comment" value="Ajouter un commentaire">
    </form>
    <a href="../index.php"><button>Retour à l'accueil</button></a>
    <a href="logout.php"><button>Se déconnecter</button></a>
</body>
</html>
