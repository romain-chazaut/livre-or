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

    if (empty($login)) {
        $error = "Veuillez fournir un nom d'utilisateur !";
    } elseif (empty($password)) {
        $error = "Veuillez fournir un mot de passe !";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères !";
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
    <!-- Ajoutez votre CSS ici -->
</head>
<body>
    <h1>Inscription</h1>
    <?php if (isset($error)) echo htmlspecialchars($error); ?>
    <form method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="btn-register">S'inscrire</button>
    </form>
    <a href="../index.php"><button>Retour à l'accueil</button></a>
</body>
</html>
