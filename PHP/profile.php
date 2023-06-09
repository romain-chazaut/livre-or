<?php
// Start the session
session_start();

// Include the User class file
require_once '../class/user.php';

// Create a new User object
$user = new User();

// If the user is not logged in, redirect them to the index page
if (!$user->is_loggedin()) {
    $user->redirect('../index.php');
}

// Check if the update profile form has been submitted
if (isset($_POST['btn-update'])) {
    $login = $_POST['username'];
    $password = $_POST['password'];

    // Perform validation checks on the submitted data
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
        // If the validation checks pass, attempt to update the user's profile
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
    <link rel="stylesheet" href="../CSS/profile.css">
</head>
<body>
    <div class="navbar">
        <h1 class="nav-title">Profil</h1>
        <div class="nav-links">
            <a href="logout.php" class="nav-link">Se déconnecter</a>
        </div>
    </div>

    <div class="comment">
        <?php if (isset($error)) echo "<p>" . $error . "</p>"; ?>

        <!-- Provide a form for the user to update their profile -->
        <form method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <div class="form-buttons">
                <input type="submit" name="btn-update" value="Mettre à jour">
                <a href="golden-book.php" class="button">Livre d'or</a>                
            </div>
        </form>
    </div>
</body>
</html>
