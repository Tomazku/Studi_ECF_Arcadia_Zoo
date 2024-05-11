<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

function fetchHabitatDetails($habitat_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT habitat_id, nom, description, image FROM habitat WHERE habitat_id = ?");
    $stmt->execute([$habitat_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$habitat_id = $_GET['habitat_id'] ?? null;
if (!$habitat_id) {
    die("Aucun ID d'habitat spécifié. Veuillez spécifier un ID d'habitat dans l'URL, par exemple ?habitat_id=1.");
}

$habitatDetails = fetchHabitatDetails($habitat_id);

if (!$habitatDetails) {
    die("Habitat non trouvé ou ID non valide.");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Habitat</title>
</head>
<body>
    <h1><?= htmlspecialchars($habitatDetails['nom']); ?></h1>
    <img src="<?= htmlspecialchars($habitatDetails['image']) ?>" alt="<?= htmlspecialchars($habitatDetails['nom']) ?>" style="width: 200px; height: auto;">
    <p><?= htmlspecialchars($habitatDetails['description']); ?></p>
</body>
</html>
