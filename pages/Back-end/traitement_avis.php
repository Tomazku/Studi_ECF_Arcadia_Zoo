<?php
// Connexion à la base de données 
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $pseudo = $_POST['pseudo'];
    $commentaire = $_POST['commentaire'];

    // Préparation de la requête d'insertion
    $query = "INSERT INTO avis (pseudo, commentaire, isVisible) VALUES (:pseudo, :commentaire, 0)";
    $statement = $pdo->prepare($query);

    // Exécution de la requête d'insertion
    $statement->execute(array(':pseudo' => $pseudo, ':commentaire' => $commentaire));

    // Redirection vers la page d'accueil ou une autre page après l'envoi de l'avis
    header('Location: index.php');
    exit;
}
?>
