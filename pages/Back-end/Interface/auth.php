<?php

// Démarrez la session PHP
session_start();

// Connexion à la base de données
require_once('./pages/Includes/config.php');

// Vérification des informations de connexion
function authenticate($email, $mot_de_passe) {
    global $pdo;
    
    // Requête pour vérifier les informations d'identification
    $query = "SELECT * FROM utilisateurs WHERE email = :email AND mot_de_passe = :mot_de_passe";
    $statement = $pdo->prepare($query);
    $statement->execute(array(
        ':email' => $email,
        ':mot_de_passe' => $mot_de_passe
    ));
    
    // Vérification du résultat de la requête
    $utilisateur = $statement->fetch(PDO::FETCH_ASSOC);
    return $utilisateur;
}

// Vérifiez si l'utilisateur est connecté
function check_authentication() {
    if (!isset($_SESSION['utilisateur_id'])) {
        // Rediriger vers la page de connexion
        header('Location: login.php');
        exit();
    }
}

?>
