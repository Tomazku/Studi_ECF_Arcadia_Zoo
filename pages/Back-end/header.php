<?php
require_once('auth.php');
check_authentication();

function getUserRole() {
    global $pdo;
    $query = "SELECT role FROM utilisateurs WHERE utilisateur_id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(array(':id' => $_SESSION['utilisateur_id']));
    $utilisateur = $statement->fetch(PDO::FETCH_ASSOC);
    return $utilisateur['role'];
}

$role = getUserRole();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia Zoo</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
    <nav class="sidebar">
        <ul>
            <?php if ($role == 'admin'): ?>
                <li><a href="./creation_compte.php">Gestion des utilisateurs</a></li>
                <li><a href="../Back-end/animals/addAnimal.php">Ajout d'animaux</a></li>
                <li><a href="./animal.php">Gestion des animaux</a></li>
                <li><a href="./animals/habitats.php">Gestion des habitats</a></li>
                <li><a href="./gestion_horaires.php">Gestion des horaires</a></li>
                <li><a href=".//avis/administration_avis.php">Gestion des avis</a></li>
                <li><a href="./contact_BG.php">Contact</a></li>
            <?php elseif ($role == 'veterinaire'): ?>
                <li><a href="./animals/addAnimal.php">Ajout d'animaux</a></li>
                <li><a href="./animals/animal.php">Gestion des animaux</a></li>
                <li><a href="./animals/habitats.php">Gestion des habitats</a></li>
                <li><a href="./gestion_horaires.php">Gestion des horaires</a></li>
            <?php elseif ($role == 'employe'): ?>
                <li><a href="./animals/animal.php">Gestion des animaux</a></li>
                <li><a href="./gestion_horaires.php">Gestion des horaires</a></li>
                <li><a href="./administration_avis.php">Gestion des avis</a></li>
                <li><a href="./contact_BG.php">Contact</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>
