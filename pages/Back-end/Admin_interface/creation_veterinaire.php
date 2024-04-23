<?php
// Inclure le fichier de configuration de la base de données
include './pages/Includes/config.php';

// Récupérer les données du formulaire
$veterinaire_email = $_POST['veterinaire_email'];
$veterinaire_password = $_POST['veterinaire_password'];

// Préparer la requête SQL pour insérer les données dans la table des vétérinaires
$sql = "INSERT INTO veterinaire (nom, motDePasse) VALUES ('$veterinaire_email', '$veterinaire_password')";

// Exécuter la requête
if (mysqli_query($conn, $sql)) {
    echo "Compte vétérinaire créé avec succès.";
} else {
    echo "Erreur lors de la création du compte vétérinaire : " . mysqli_error($conn);
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
