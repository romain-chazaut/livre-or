<?php
session_start();
require_once '../class/user.php';
$user = new User();

if ($user->is_loggedin()) {
    $user->redirect('profile.php');
}

if (isset($_POST['btn-login'])) {
    $uname = $_POST['username'];
    $upass = $_POST['password'];

    if ($user->login($uname, $upass)) {
        $user->redirect('profile.php');
    } else {
        $error = "Mauvais identifiants !";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Connexion</h1>
    <?php if (isset($error)) echo $error; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="btn-login">Se connecter</button>
    </form>
    <a href="../index.php"><button>Retour à l'accueil</button></a>
</body>
</html>
