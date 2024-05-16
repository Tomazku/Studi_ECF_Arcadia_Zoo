<?php
include('./pages/Back-end/pdo.php');

// Modifier la requête pour inclure la catégorie et trier par catégorie
$sql = "SELECT nom, description, image_service, categorie FROM service ORDER BY categorie, nom";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$groupedResults = [];

// Grouper les résultats par catégorie
foreach ($results as $row) {
    $groupedResults[$row['categorie']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Services - Arcadia Zoo</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">
</head>
<body>
<?php include 'assets/includes/header.php'; ?>

<h1 class="service_title">Services disponibles au <span class="orange-text">Zoo Arcadia</span></h1>
<div class="service-card">
    <?php if (!empty($groupedResults)) : ?>
        <?php foreach ($groupedResults as $categorie => $services) : ?>
            <h2 class="categorie-title"><?= htmlspecialchars($categorie); ?></h2>
            <div id="categorie-<?= strtolower(str_replace(' ', '-', $categorie)); ?>" class="categorie-section">
                <?php foreach ($services as $service) : ?>
                    <h3 class="service_subtitle"><?= ($service['nom']); ?></h3>
                    <div class="service-content">
                        <div class="text_content"><?= ($service['description']); ?></div>
                        <div class="service_image">
                            <img src="./pages/Back-end/uploads/<?= ($service['image_service']); ?>" alt="Image de <?= ($service['nom']); ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Aucun service disponible.</p>
    <?php endif; ?>
</div>

<?php include 'assets/includes/footer.php'; ?>

</body>
</html>
