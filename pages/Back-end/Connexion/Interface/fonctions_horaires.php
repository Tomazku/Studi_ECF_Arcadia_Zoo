<?php
// Inclure le fichier de connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Fonction pour récupérer les horaires d'ouverture depuis la base de données
function getHorairesOuverture() {
    global $pdo;
    $query = "SELECT * FROM horaires_ouverture";
    $statement = $pdo->query($query);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour mettre à jour les horaires d'ouverture dans la base de données
function updateHorairesOuverture($id, $heure_ouverture, $heure_fermeture, $ferme) {
    global $pdo;
    $query = "UPDATE horaires_ouverture SET heure_ouverture = :heure_ouverture, heure_fermeture = :heure_fermeture, fermé = :ferme WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute([
        ':id' => $id,
        ':heure_ouverture' => $heure_ouverture,
        ':heure_fermeture' => $heure_fermeture,
        ':ferme' => $ferme
    ]);
}
?>
