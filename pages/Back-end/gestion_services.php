<?php
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Ajout d'un service
if (isset($_POST['ajouter'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $pdo->prepare("INSERT INTO service (nom, description, image_service) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $description, $image]);
        header("Location: gestion_services.php");
        exit;
    } else {
        echo "Échec de l'upload de l'image.";
    }
}

// Mise à jour d'un service
if (isset($_POST['modifier']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if ($image) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $stmt = $pdo->prepare("UPDATE service SET nom = ?, description = ?, image_service = ? WHERE service_id = ?");
            $stmt->execute([$nom, $description, $image, $id]);
        } else {
            echo "Échec de l'upload de l'image.";
        }
    } else {
        $stmt = $pdo->prepare("UPDATE service SET nom = ?, description = ? WHERE service_id = ?");
        $stmt->execute([$nom, $description, $id]);
    }
    header("Location: gestion_services.php");
    exit;
}

// Suppression d'un service
if (isset($_POST['supprimer']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM service WHERE service_id = ?");
    $stmt->execute([$id]);
    header("Location: gestion_services.php");
    exit;
}

// Récupération de tous les services pour l'affichage
$stmt = $pdo->prepare("SELECT * FROM service");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Services - Arcadia Zoo</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
</head>
<body>

<h1>Gestion des Services - Arcadia Zoo</h1>

<!-- Formulaire pour ajouter un nouveau service -->
<h2>Ajouter un nouveau service</h2>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="nom" placeholder="Nom du service" required>
    <textarea name="description" placeholder="Description du service" required></textarea>
    <input type="file" name="image" required>
    <button type="submit" name="ajouter">Ajouter Service</button>
</form>

<!-- Liste des services existants -->
<h2>Liste des Services</h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($services as $service) : ?>
    <tr>
        <td><?= htmlspecialchars($service['nom']); ?></td>
        <td><?= htmlspecialchars($service['description']); ?></td>
        <td><img src="uploads/<?= htmlspecialchars($service['image_service']); ?>" alt="Image" style="width:100px;"></td>
        <td>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $service['service_id']; ?>">
                <input type="text" name="nom" value="<?= $service['nom']; ?>" required>
                <input type="text" name="description" value="<?= $service['description']; ?>" required>
                <input type="file" name="image">
                <button type="submit" name="modifier">Modifier</button>
                <button type="submit" name="supprimer">Supprimer</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
