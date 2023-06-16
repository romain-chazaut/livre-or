 <?php
 session_start();
 require_once 'class/user.php';
 $user = new User();

if ($user->is_loggedin()) {
     $user->redirect('PHP/profile.php');
 }

 if (isset($_POST['btn-login'])) {
     $uname = $_POST['username'];
     $upass = $_POST['password'];

     if ($user->login($uname, $upass)) {
         $user->redirect('PHP/profile.php');
     } else {
         $error = "Mauvais identifiants !";
    }
 }
?> 

<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
</head>
<body>
    <h1>Accueil</h1>
    <link rel="stylesheet" type="text/css" href="index.css">
    <?php if (isset($error)) echo $error; ?>
    <!-- <form method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="btn-login">Se connecter</button>
    </form> -->
    <a href="PHP/register.php"><button>S'inscrire</button></a>
    <a href="PHP/login.php"><button>Connexion</button></a>
</body>
</html>
