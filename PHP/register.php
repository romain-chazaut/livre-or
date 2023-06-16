<?php
session_start();
require_once '../class/user.php';
$user = new User();

if ($user->is_loggedin()) {
    $user->redirect('profile.php');
}

if (isset($_POST['btn-register'])) {
    $login = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($login)) {
        $error = "Veuillez fournir un nom d'utilisateur !";
    } elseif (empty($password)) {
        $error = "Veuillez fournir un mot de passe !";
    } elseif (empty($confirm_password)) {
        $error = "Veuillez confirmer votre mot de passe !";
    } elseif ($password != $confirm_password) {
        $error = "Les mots de passe ne correspondent pas !";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères !";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $error = "Le mot de passe doit contenir au moins une majuscule !";
    } elseif (!preg_match("/\d/", $password)) {
        $error = "Le mot de passe doit contenir au moins un chiffre !";
    } elseif (!preg_match("/\W/", $password)) {
        $error = "Le mot de passe doit contenir au moins un caractère spécial !";
    } else {
        if ($user->register($login, $password)) {
            $user->redirect('login.php');
        } else {
            $error = "Une erreur s'est produite lors de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="../CSS/register.css"> 
</head>
<body>
    <h1>Inscription</h1>
    <?php if (isset($error)) echo htmlspecialchars($error); ?>
    <form method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
        <button type="submit" name="btn-register">S'inscrire</button>
    </form>
    <a href="login.php"><button>Retour à l'accueil</button></a>
</body>
</html>

