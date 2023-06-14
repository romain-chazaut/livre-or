<?php
session_start();
require_once '../class/user.php';
require_once '../class/comment.php';
$user = new User();
$comment = new Comment();

if (!$user->is_loggedin()) {
    $user->redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_comment'])) {
        $content = $_POST['content'];
        $comment->addComment($content, $_SESSION['user_session']);
    } elseif (isset($_POST['delete_comment'])) {
        $commentId = $_POST['comment_id'];
        $comment->deleteComment($commentId, $_SESSION['user_session']);
    }
    // Refresh the page
    header('Location: '.$_SERVER['REQUEST_URI']);
    exit;
}

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
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <p>Posté le <?php echo htmlspecialchars($comment['date']); ?> par <?php echo htmlspecialchars($comment['username']); ?></p>
            <p><?php echo htmlspecialchars($comment['comment']); ?></p>
            <?php if ($comment['id_user'] === $_SESSION['user_session']): ?>
                <form method="POST">
                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                    <input type="submit" name="delete_comment" value="Supprimer">
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <form method="POST">
        <textarea name="content" required></textarea>
        <input type="submit" name="new_comment" value="Ajouter un commentaire">
    </form>
    <a href="index.php"><button>Retour à l'accueil</button></a>
    <a href="logout.php"><button>Se déconnecter</button></a>
</body>
</html>
