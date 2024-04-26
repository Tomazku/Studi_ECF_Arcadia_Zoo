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
function updateHoraires($horaires) {
    global $pdo;
    foreach ($horaires as $id => $horaire) {
        $heure_ouverture = $horaire['heure_ouverture'];
        $heure_fermeture = $horaire['heure_fermeture'];
        $ferme = isset($horaire['ferme']) ? 1 : 0; // Convertir en 1 ou 0 pour le stockage dans la base de données

        $query = "UPDATE horaires_ouverture SET heure_ouverture = :heure_ouverture, heure_fermeture = :heure_fermeture, ferme = :ferme WHERE horaire_id = :id";
        $statement = $pdo->prepare($query);
        $statement->execute([
            ':id' => $id,
            ':heure_ouverture' => $heure_ouverture,
            ':heure_fermeture' => $heure_fermeture,
            ':ferme' => $ferme
        ]);
    }
}
?>
