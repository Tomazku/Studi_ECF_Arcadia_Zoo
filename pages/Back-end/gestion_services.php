<?php
include('header.php');
include('./pdo.php');

// Ajout d'un service
if (isset($_POST['ajouter'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $pdo->prepare("INSERT INTO service (nom, description, image_service, categorie) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $description, $image, $categorie]);
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
    $categorie = $_POST['categorie'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (!empty($image)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $stmt = $pdo->prepare("UPDATE service SET nom = ?, description = ?, image_service = ?, categorie = ? WHERE service_id = ?");
            $stmt->execute([$nom, $description, $image, $categorie, $id]);
        } else {
            echo "Échec de l'upload de l'image.";
        }
    } else {
        $stmt = $pdo->prepare("UPDATE service SET nom = ?, description = ?, categorie = ? WHERE service_id = ?");
        $stmt->execute([$nom, $description, $categorie, $id]);
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
$stmt = $pdo->prepare("SELECT * FROM service ORDER BY categorie, nom");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Services - Arcadia Zoo</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
<div class="service-management-container">
<h1>Gestion des Services - Arcadia Zoo</h1>

<!-- Formulaire pour ajouter un nouveau service -->
<h2>Ajouter un nouveau service</h2>
<form class="service-form" method="post" enctype="multipart/form-data">
    <input type="text" name="nom" placeholder="Nom du service" required>
    <textarea name="description" placeholder="Description du service" required></textarea>
    <select name="categorie" required>
        <option value="">-- Sélectionner une catégorie --</option>
        <option value="Restaurants">Restaurants</option>
        <option value="Activités">Activités</option>
        <option value="Animations">Animations</option>
    </select>
    <input type="file" name="image" required>
    <button type="submit" name="ajouter">Ajouter Service</button>
</form>

<!-- Liste des services existants -->
<h2>Liste des Services</h2>
<table class="service-table">
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Catégorie</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($services as $service) : ?>
    <tr>
        <td><?= htmlspecialchars($service['nom']); ?></td>
        <td><?= htmlspecialchars($service['description']); ?></td>
        <td><?= htmlspecialchars($service['categorie']); ?></td>
        <td><img src="uploads/<?= htmlspecialchars($service['image_service']); ?>" alt="Image" style="width:100px;"></td>
        <td>
            <form method="post" enctype="multipart/form-data" class="action-form">
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
    </div>
</table>
<?php
include('footer.php');
?>

</body>
</html>
