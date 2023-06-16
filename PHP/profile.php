<?php
session_start();
require_once '../class/user.php';
$user = new User();

if (!$user->is_loggedin()) {
    $user->redirect('login.php');
}

if (isset($_POST['btn-update'])) {
    $login = $_POST['username'];
    $password = $_POST['password'];

    if (empty($login)) {
        $error = "Veuillez fournir un nom d'utilisateur !";
    } elseif (empty($password)) {
        $error = "Veuillez fournir un mot de passe !";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères !";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $error = "Le mot de passe doit contenir au moins une majuscule !";
    } elseif (!preg_match("/\d/", $password)) {
        $error = "Le mot de passe doit contenir au moins un chiffre !";
    } elseif (!preg_match("/\W/", $password)) {
        $error = "Le mot de passe doit contenir au moins un caractère spécial !";
    } else {
        if ($user->updateProfile($login, $password)) {
            $user->redirect('profile.php');
        } else {
            $error = "Une erreur s'est produite lors de la mise à jour du profil.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
</head>
<body>
    <h1>Profil</h1>
    <?php if (isset($error)) echo $error; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="btn-update">Mettre à jour</button>
    </form>
    <a href="logout.php"><button>Se déconnecter</button></a>
    <a href="golden-book.php"><button>Livre D'or</button></a>
</body>
</html>
