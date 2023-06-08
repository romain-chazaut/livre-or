<?php
require_once 'PHP\user.php'; // Assurez-vous que le chemin d'accès est correct

$loginErr = $passwordErr = $confirmPasswordErr = "";
$login = $password = $confirmPassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation du login
    if (empty($_POST["login"])) {
        $loginErr = "Le login est requis";
    } else {
        $login = $_POST["login"];
    }

    // Validation du mot de passe
    if (empty($_POST["password"])) {
        $passwordErr = "Le mot de passe est requis";
    } else {
        $password = $_POST["password"];
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $password)) {
            $passwordErr = "Le mot de passe doit avoir au moins 8 caractères, une lettre, un chiffre et un caractère spécial";
        }
    }

    // Validation de la confirmation du mot de passe
    if (empty($_POST["confirmPassword"])) {
        $confirmPasswordErr = "La confirmation du mot de passe est requise";
    } else {
        $confirmPassword = $_POST["confirmPassword"];
        if ($password != $confirmPassword) {
            $confirmPasswordErr = "Les mots de passe ne correspondent pas";
        }
    }

    // Si aucune erreur, alors on peut enregistrer l'utilisateur
    if (empty($loginErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        $user = new User($login, $password);
        // $user->save(); // La méthode save doit être définie dans votre classe User
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Ajoutez votre CSS ici -->
</head>
<body>
    <h2>Inscription</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Login: <input type="text" name="login" value="<?php echo $login;?>">
        <span class="error">* <?php echo $loginErr;?></span>
        <br><br>
        Mot de passe: <input type="password" name="password">
        <span class="error">* <?php echo $passwordErr;?></span>
        <br><br>
        Confirmer le mot de passe: <input type="password" name="confirmPassword">
        <span class="error">* <?php echo $confirmPasswordErr;?></span>
        <br><br>
        <input type="submit" name="submit" value="S'inscrire">  
    </form>
</body>
</html>
