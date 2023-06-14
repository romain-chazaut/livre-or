<?php
session_start();
require_once '../class/user.php';
$user = new User();

if (!$user->is_loggedin()) {
    $user->redirect('../index.php');
}

if (isset($_POST['btn-update'])) {
    $login = $_POST['username'];
    $password = $_POST['password'];

    if (empty($login)) {
        $error = "Veuillez fournir un nom d'utilisateur !";
    } elseif (empty($password)) {
        $error = "Veuillez fournir un mot de passe !";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères !";
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
    <a href="login.php"><button>Retour à l'accueil</button></a>
    <a href="logout.php"><button>Se déconnecter</button></a>
</body>
</html>
