<?php
session_start();
require_once '../class/user.php';
$user = new User();

if ($user->logout()) {
    $user->redirect('login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Déconnexion</title>
</head>
<body>
    <h1>Vous avez été déconnecté.</h1>
    <a href="login.php">Se connecter</a>
</body>
</html>
