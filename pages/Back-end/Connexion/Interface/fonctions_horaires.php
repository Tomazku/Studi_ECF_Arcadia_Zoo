<?php
// Inclure le fichier de connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');



// Fonction pour mettre à jour les horaires d'ouverture dans la base de données
function updateHorairesOuverture($jour, $ferme, $heure_ouverture, $heure_fermeture) {
    global $pdo;
    // Préparer la requête en fonction de l'état de fermeture
    if ($ferme) {
        $query = "UPDATE horaires_ouverture SET fermé = true, heure_ouverture = NULL, heure_fermeture = NULL WHERE jour = :jour";
    } else {
        $query = "UPDATE horaires_ouverture SET fermé = false, heure_ouverture = :heure_ouverture, heure_fermeture = :heure_fermeture WHERE jour = :jour";
    }
    // Exécuter la requête préparée
    $statement = $pdo->prepare($query);
    $statement->execute([
        ':jour' => $jour,
        ':heure_ouverture' => $heure_ouverture,
        ':heure_fermeture' => $heure_fermeture
    ]);
}
?>
