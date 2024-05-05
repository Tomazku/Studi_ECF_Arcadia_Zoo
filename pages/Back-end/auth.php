<?php

// Démarrez la session PHP
session_start();

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Vérification des informations de connexion
function authenticate($email, $motDePasse) {
    global $pdo;
    
    // Requête pour vérifier les informations d'identification
    $query = "SELECT * FROM utilisateurs WHERE email = :email AND motDePasse = :motDePasse";
    $statement = $pdo->prepare($query);
    $statement->execute(array(
        ':email' => $email,
        ':motDePasse' => $motDePasse
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

// Vérifiez si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse'];

    // Authentifier l'utilisateur
    $utilisateur = authenticate($email, $motDePasse);
    
    // Vérifier si l'authentification a réussi
    if ($utilisateur) {
        // Démarrer la session et stocker l'ID de l'utilisateur
        $_SESSION['utilisateur_id'] = $utilisateur['id'];
        
        // Rediriger l'utilisateur en fonction de son rôle
        switch ($utilisateur['role']) {
            case 'admin':
                header('Location: interface_admin.php');
                exit();
            case 'veterinaire':
                header('Location: interface_veterinaire.php');
                exit();
            // Ajoutez d'autres cas pour d'autres rôles si nécessaire
            default:
                // Rediriger vers une page par défaut si le rôle n'est pas reconnu
                header('Location: interface_employe.php');
                exit();
        }
    } else {
        // Rediriger vers la page de connexion avec un message d'erreur
        header('Location: login.php?error=1');
        exit();
    }
}

?>
