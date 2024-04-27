<?php
require_once('auth.php');

// Fonction pour récupérer les utilisateurs depuis la base de données
function getUtilisateurs() {
    global $pdo;
    $query = "SELECT email, role FROM utilisateurs";
    $statement = $pdo->query($query);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les utilisateurs depuis la base de données
$utilisateurs = getUtilisateurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
    <!-- Menu de navigation vertical fixe -->
    <nav class="sidebar">
        <ul>
            <li><a href="#">Tableau de bord</a></li>
            <li><a href="#">Gestion des utilisateurs</a></li>
            <li><a href="#">Gestion des animaux</a></li>
            <!-- Ajoutez d'autres liens de navigation ici -->
        </ul>
    </nav>
