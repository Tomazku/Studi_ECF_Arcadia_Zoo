<?php
session_start();
include('./pages/Back-end/pdo.php');

// Récupérer tous les habitats
$stmt = $pdo->query("SELECT habitat_id, nom, description, image FROM habitat");
$habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Habitats du Zoo</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">    
</head>
<body>
    <?php include 'assets/includes/header.php'; ?>
    <div class="container-breadcrumb">
        <div class="breadcrumb">
            <a href="index.php">Accueil</a> &gt; <a href="habitats.php">Habitats</a>
        </div>
    </div>
    <div class="habitat-title">
    <h1>Découvrez nos <span class="orange-text">Habitats</span></h1>
    </div>
    <div class="habitat-container">
        <?php foreach ($habitats as $habitat): ?>
            <div class="habitat-card">
                <img src="./pages/Back-end/animals/<?= htmlspecialchars($habitat['image']) ?>" alt="Habitat de <?= htmlspecialchars($habitat['nom']) ?>" class="habitat-image">
                <div class="habitat-info">
                    <h2><?= htmlspecialchars($habitat['nom']); ?></h2>
                    <p><?= htmlspecialchars($habitat['description']); ?></p>
                    <a href="animaux.php?habitat_id=<?= $habitat['habitat_id'] ?>" class="button habitat-button">Découvrez les animaux</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="section-importance-nature">
    <img src="assets/images/natural-habitat.jpg" alt="Milieu Naturel" class="section-image">
    <div class="text-content">
        <h2>Importance d'un milieu naturel</h2>
        <p>Offrir un habitat qui se rapproche au maximum du milieu naturel des animaux est essentiel pour leur bien-être psychologique et physique. Cela favorise des comportements naturels, essentiels à la santé de chaque espèce.</p>
    </div>
</div>
<a href="./pages/Back-end/animals/uploads/"></a>
<div class="section-importance-nature">
    <div class="text-content">
        <h2>Conservation et éducation</h2>
        <p>Chaque habitat est conçu non seulement pour le confort des animaux, mais aussi pour éduquer le public sur les écosystèmes spécifiques et l'importance de la conservation de la biodiversité.</p>
    </div>
    <img src="assets/images/conservation.jpg" class="section-image alt="Conservation de la biodiversité">
</div>

    <?php include 'assets/includes/footer.php'; ?>
</body>
</html>
