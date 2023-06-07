<!DOCTYPE html>
<html>
<head>
    <title>Inscription et Connexion</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Ajoutez votre CSS ici -->
</head>
<body>
    <header>
        <h1>Inscription et Connexion</h1>
    </header>

    <section>
        <h2>Inscription</h2>
        <form action="signup.php" method="post">
            <label for="signup-login">Login:</label>
            <input type="text" id="signup-login" name="login">
            <label for="signup-password">Password:</label>
            <input type="password" id="signup-password" name="password">
            <input type="submit" value="S'inscrire">
        </form>
    </section>

    <section>
        <h2>Connexion</h2>
        <form action="login.php" method="post">
            <label for="login-login">Login:</label>
            <input type="text" id="login-login" name="login">
            <label for="login-password">Password:</label>
            <input type="password" id="login-password" name="password">
            <input type="submit" value="Se connecter">
        </form>
    </section>
    
    <footer>
        
    </footer>
</body>
</html>
