<?php
// Vérifiez si une session est déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('./pdo.php');


function authenticate($email, $motDePasse) {
    global $pdo;
    
    $query = "SELECT * FROM utilisateurs WHERE email = :email AND motDePasse = :motDePasse";
    $statement = $pdo->prepare($query);
    $statement->execute(array(
        ':email' => $email,
        ':motDePasse' => $motDePasse
    ));
    
    $utilisateur = $statement->fetch(PDO::FETCH_ASSOC);
    return $utilisateur;
}

function check_authentication() {
    if (!isset($_SESSION['utilisateur_id'])) {
        header('Location: login.php');
        exit();
    }
}

function check_role($required_roles) {
    global $pdo;
    
    if (!isset($_SESSION['utilisateur_id'])) {
        header('Location: login.php');
        exit();
    }
    
    $query = "SELECT role FROM utilisateurs WHERE utilisateur_id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(array(':id' => $_SESSION['utilisateur_id']));
    $utilisateur = $statement->fetch(PDO::FETCH_ASSOC);
    
    if (!in_array($utilisateur['role'], $required_roles)) {
        header('Location: unauthorized.php');
        exit();
    }
}
?>
