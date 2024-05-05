<?php
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

$sql = "SELECT nom, description, image_service FROM service";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Services - Arcadia Zoo</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="stylesheet" href="main.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">
</head>
<body>
<?php include 'assets/includes/header.php'; ?>

<h1 class="service_title">Services disponibles au <span class="orange-text">Zoo Arcadia</span></h1>
<div class="service-card">
    <?php if ($results) : ?>
        <?php foreach ($results as $row) : ?>
            <div class="service_subtitle"><?= htmlspecialchars($row['nom']) ?></div>
        <div class="service_content">
            <div class="text_content"><?= htmlspecialchars($row['description']) ?></div>
            <div class="service_image">
                <img src="./pages/Back-end/uploads/<?= htmlspecialchars($row['image_service']) ?>" alt="Image de <?= htmlspecialchars($row['nom']) ?>">
            </div>
        </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Aucun service disponible.</p>
    <?php endif; ?>
</div>

<?php include 'assets/includes/footer.php'; ?>

</body>
</html>
