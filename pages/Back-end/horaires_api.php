<?php
// Configuration de la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["message" => "Erreur de connexion à la base de données : " . $e->getMessage()]));
}

// Récupération des données depuis le client
$requestMethod = $_SERVER["REQUEST_METHOD"];
$input = json_decode(file_get_contents('php://input'), true);

// Fonction pour récupérer les horaires
function getHoraires($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM horaires_ouverture");
        $horaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($horaires);
    } catch (PDOException $e) {
        return json_encode(["message" => "Erreur lors de la récupération des horaires : " . $e->getMessage()]);
    }
}

// Fonction pour mettre à jour un horaire
function updateHoraire($pdo, $data) {
    // Ajoutez un log pour inspecter les données reçues
    error_log("Données reçues par l'API : " . json_encode($data));
    if (!isset($data['horaires_id'])) {
        error_log("Clé `horaires_id` manquante ou invalide.");
        return json_encode(["message" => "Clé manquante ou invalide : horaires_id"]);
    }
    // Vérifiez que toutes les clés nécessaires sont présentes
    $required_keys = ['horaires_id', 'jour', 'heure_ouverture', 'heure_fermeture', 'ferme'];
    foreach ($required_keys as $key) {
        if (!isset($data[$key])) {
            error_log("Clé manquante ou invalide : $key");
            return json_encode(["message" => "Clé manquante ou invalide : $key"]);
        }
    }

    // Récupérez les valeurs après validation
    $id = $data['horaires_id'];
    $jour = $data['jour'];
    $heure_ouverture = $data['heure_ouverture'];
    $heure_fermeture = $data['heure_fermeture'];
    $ferme = $data['ferme'] ? 1 : 0;

    try {
        $stmt = $pdo->prepare(
            "UPDATE horaires_ouverture SET jour = ?, heure_ouverture = ?, heure_fermeture = ?, ferme = ? WHERE horaires_id = ?"
        );
        $success = $stmt->execute([$jour, $heure_ouverture, $heure_fermeture, $ferme, $id]);

        return json_encode(["message" => $success ? "Horaire mis à jour" : "Erreur de mise à jour"]);
    } catch (PDOException $e) {
        error_log("Erreur de mise à jour : " . $e->getMessage());
        return json_encode(["message" => "Erreur de mise à jour : " . $e->getMessage()]);
    }
}


// Gestion des requêtes API
if (in_array($_SERVER['REQUEST_METHOD'], ['GET', 'PUT'])) {
    switch ($requestMethod) {
        case "GET":
            echo getHoraires($pdo);
            break;
        case "PUT":
            echo updateHoraire($pdo, $input);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Méthode non autorisée"]);
            break;
    }
    exit;
}
