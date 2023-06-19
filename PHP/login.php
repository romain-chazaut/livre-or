<?php
// Start the session
session_start();

// Include the User class file
require_once '../class/user.php';

// Create a new User object
$user = new User();

// If the user is already logged in, redirect them to the profile page
if ($user->is_loggedin()) {
    $user->redirect('profile.php');
}

// Check if the login form has been submitted
if (isset($_POST['btn-login'])) {
    // Store the posted username and password in variables
    $uname = $_POST['username'];
    $upass = $_POST['password'];

    // Try to log the user in
    if ($user->login($uname, $upass)) {
        // If successful, redirect to the profile page
        $user->redirect('profile.php');
    } else {
        // If unsuccessful, store an error message to display later
        $error = "Mauvais identifiants !";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="../CSS/login.css"> <!-- Link the CSS stylesheet -->
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <?php if (isset($error)) echo $error; ?> <!-- Display any login errors -->
        <form method="post"> <!-- Login form -->
            <input type="text" name="username" placeholder="Nom d'utilisateur" required> <!-- Input for username -->
            <input type="password" name="password" placeholder="Mot de passe" required> <!-- Input for password -->
            <div class="button-group">
                <button type="submit" name="btn-login">Se connecter</button> <!-- Submit button for the form -->
                <a href="../index.php"><button type="button">Retour à l'accueil</button></a> <!-- Button to return to the homepage -->
            </div>
        </form>
    </div>
</body>
</html>
