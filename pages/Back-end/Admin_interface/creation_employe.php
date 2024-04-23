<?php
include './pages/Includes/config.php';

// Récupérer les données du formulaire
$employe_email = $_POST['employe_email'];
$employe_password = $_POST['employe_password'];

// Préparer la requête SQL pour insérer les données dans la table des employés
$sql = "INSERT INTO employes (nom, motDePasse) VALUES ('$employe_email', '$employe_password')";

// Exécuter la requête
if (mysqli_query($conn, $sql)) {
    echo "Compte employé créé avec succès.";
} else {
    echo "Erreur lors de la création du compte employé : " . mysqli_error($conn);
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
