<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('./pdo.php');

function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function authenticate($email, $motDePasse) {
    global $pdo;

    $email = validateInput($email);
    $motDePasse = validateInput($motDePasse);

    $query = "SELECT * FROM utilisateurs WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->execute([':email' => $email]);
    $utilisateur = $statement->fetch(PDO::FETCH_ASSOC);

    var_dump($utilisateur); // Debug: Afficher les informations de l'utilisateur

    if ($utilisateur && password_verify($motDePasse, $utilisateur['motDePasse'])) {
        return $utilisateur;
    }

    return false;
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
    $statement->execute([':id' => $_SESSION['utilisateur_id']]);
    $utilisateur = $statement->fetch(PDO::FETCH_ASSOC);

    if (!in_array($utilisateur['role'], $required_roles)) {
        header('Location: unauthorized.php');
        exit();
    }
}
?>