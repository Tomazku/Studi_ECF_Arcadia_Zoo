<?php
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
    foreach ($horaires as $horaires_id => $horaire) {
        $heure_ouverture = $horaire['heure_ouverture'];
        $heure_fermeture = $horaire['heure_fermeture'];
        $ferme = isset($horaire['ferme']) ? 1 : 0; // Convertir en 1 ou 0 pour le stockage dans la base de données

        // Ajout de la conversion des heures au format 'HH:MM:SS' pour la base de données
        $heure_ouverture = date('H:i:s', strtotime($heure_ouverture));
        $heure_fermeture = date('H:i:s', strtotime($heure_fermeture));

        $query = "UPDATE horaires_ouverture SET heure_ouverture = :heure_ouverture, heure_fermeture = :heure_fermeture, ferme = :ferme WHERE horaires_id = :horaires_id";
        $statement = $pdo->prepare($query);
        $statement->execute([
            ':horaires_id' => $horaires_id,
            ':heure_ouverture' => $heure_ouverture,
            ':heure_fermeture' => $heure_fermeture,
            ':ferme' => $ferme
        ]);
    }
}
?>
