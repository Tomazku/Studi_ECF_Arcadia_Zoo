<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Récupérer tous les habitats
$stmt = $pdo->query("SELECT habitat_id, nom, description, commentaire_habitat FROM habitat");
$habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Habitats du Zoo</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">
</head>
<body>
<?php include 'assets/includes/header.php'; ?>
    <h1>Habitats du Zoo</h1>
    <?php foreach ($habitats as $habitat): ?>
        <div onclick="showDetails(<?php echo $habitat['habitat_id']; ?>)">
            <h2><?php echo htmlspecialchars($habitat['nom']); ?></h2>
            <p>Description: <?php echo htmlspecialchars($habitat['description']); ?></p>  
        </div>
    <?php endforeach; ?>

    <script>
    function showDetails(habitatId) {
        var url = "details.php?habitat_id=" + habitatId;
        window.location.href = url;
    }
    </script>
        <?php include 'assets/includes/footer.php'; ?>

</body>
</html>


