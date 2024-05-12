<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

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
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .breadcrumb {
            padding: 10px 15px;
            background-color: #f4f4f4;
            margin-bottom: 20px;
            list-style: none;
        }
        .breadcrumb-item {
            display: inline;
            font-size: 0.9em;
        }
        .breadcrumb-item a {
            color: #0275d8;
            text-decoration: none;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            content: " > ";
            padding: 0 5px;
            color: #666;
        }
        .habitat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }
        .habitat-card {
            width: 300px;
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .habitat-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .habitat-info {
            padding: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'assets/includes/header.php'; ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Habitats</li>
        </ol>
    </nav>

    <div class="habitat-container">
        <?php foreach ($habitats as $habitat): ?>
            <div class="habitat-card">
                <img src="<?= htmlspecialchars($habitat['image']) ?>" alt="Habitat de <?= htmlspecialchars($habitat['nom']) ?>" class="habitat-image">
                <div class="habitat-info">
                    <h2><?= htmlspecialchars($habitat['nom']); ?></h2>
                    <p><?= htmlspecialchars($habitat['description']); ?></p>
                    <a href="animaux.php?habitat_id=<?= $habitat['habitat_id'] ?>" class="btn-primary">Découvrez les animaux</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include 'assets/includes/footer.php'; ?>
</body>
</html>
