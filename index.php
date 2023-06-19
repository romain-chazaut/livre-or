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
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
    <div class="center-content">
        <h1>Accueil</h1>
        <?php if (isset($error)) echo '<p class="error-message">' . $error . '</p>'; ?>
        <a href="PHP/register.php"><button>S'inscrire</button></a>
        <a href="PHP/login.php"><button>Connexion</button></a>
    </div>
</body>
</html>

