<?php
// Start the session
session_start();

// Include the User class file
require_once '../class/user.php';

// Create a new User object
$user = new User();

// Attempt to logout the user
if ($user->logout()) {
    // If successful, redirect them to the login page
    $user->redirect('login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Déconnexion</title>
</head>
<body>
    <h1>Vous avez été déconnecté.</h1> <!-- Display a message to let the user know they have been logged out -->
    <a href="login.php">Se connecter</a> <!-- Provide a link for the user to log back in -->
</body>
</html>
