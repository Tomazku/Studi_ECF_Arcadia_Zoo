<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

$habitat_id = $_GET['habitat_id'] ?? 0;  // Assurez-vous que l'ID de l'habitat est bien passé
$stmt = $pdo->prepare("SELECT animal_id, prenom, image FROM animal WHERE habitat_id = ?");
$stmt->execute([$habitat_id]);
$animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

$habitat = $pdo->prepare("SELECT nom, description FROM habitat WHERE habitat_id = ?");
$habitat->execute([$habitat_id]);
$habitat_details = $habitat->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Habitat</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php if ($habitat_details): ?>
        <h1><?php echo htmlspecialchars($habitat_details['nom']); ?></h1>
        <p><?php echo htmlspecialchars($habitat_details['description']); ?></p>
    <?php else: ?>
        <p>Habitat non trouvé.</p>
    <?php endif; ?>

    <div class="animal-container">
        <?php foreach ($animaux as $animal): ?>
            <div class="animal" onclick="openAnimalDetails(<?php echo $animal['animal_id']; ?>)">
                <img src="<?php echo htmlspecialchars($animal['image']); ?>" alt="<?php echo htmlspecialchars($animal['prenom']); ?>">
                <h4><?php echo htmlspecialchars($animal['prenom']); ?></h4>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
