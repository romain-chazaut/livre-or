<?php

class User {
    // Déclaration des propriétés
    private $id;
    private $login;
    private $password;
    private $pdo;

    // Constructeur de la classe
    public function __construct($id, $login, $password) {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->pdo = $this->connectDB();
    }

    // Méthode de connexion à la base de données
    private function connectDB() {
        try {
            // Changez les paramètres de connexion en fonction de votre configuration
            return new PDO('mysql:host=localhost;dbname=livreor;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function register($login, $password) {
        // Préparation de la requête
        $query = $this->pdo->prepare("INSERT INTO user (login, password) VALUES (:login, :password)");
    
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Exécution de la requête avec les valeurs
        $query->execute([
            ':login' => $login,
            ':password' => $hashedPassword
        ]);
    }
    

    // Méthode pour la connexion
    public function login($login, $password) {
        // Logique de connexion à ajouter ici
    }

    // Méthode pour la modification du profil
    public function updateProfile($login, $password) {
        // Logique de modification du profil à ajouter ici
    }

    // Méthodes d'accès (getters)
    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    // Méthodes de modification (setters)
    public function setId($id) {
        $this->id = $id;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}

?>
