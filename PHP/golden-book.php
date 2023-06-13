<?php
session_start();
require_once '../../class/user.php';
require_once '../../class/comment.php';
$user = new User();
$comment = new Comment();

if (!$user->is_loggedin()) {
    $user->redirect('index.php');
}

$comments = $comment->getComments();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Livre d'or</title>
    <!-- Ajoutez votre CSS ici -->
</head>
<body>
    <h1>Livre d'or</h1>
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <p>Posté le <?php echo htmlspecialchars($comment['date']); ?> par <?php echo htmlspecialchars($comment['username']); ?></p>
            <p><?php echo htmlspecialchars($comment['comment']); ?></p>
        </div>
    <?php endforeach; ?>
    <a href="comment.php"><button>Ajouter un commentaire</button></a>
    <a href="index.php"><button>Retour à l'accueil</button></a>
    <a href="logout.php"><button>Se déconnecter</button></a>
</body>
</html>
