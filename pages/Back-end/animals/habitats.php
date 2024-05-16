<?php
session_start();
include('../header.php');
include('../pdo.php');

function fetchAllHabitats() {
    global $pdo;
    return $pdo->query("SELECT habitat_id, nom, description, image, commentaire_habitat FROM habitat")->fetchAll(PDO::FETCH_ASSOC);
}

$habitats = fetchAllHabitats();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habitat_id = $_POST['habitat_id'];
    if (isset($_POST['update_description'])) {
        $description = $_POST['description'];
        $comment = $_POST['comment'];
        $imagePath = $habitats[array_search($habitat_id, array_column($habitats, 'habitat_id'))]['image'];

        // Process image upload
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = 'uploads/';
            $imageName = basename($_FILES['image']['name']);
            $uploadedFilePath = $uploadDir . $imageName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFilePath)) {
                $imagePath = $uploadedFilePath;
            }
        }

        $stmt = $pdo->prepare("UPDATE habitat SET description = ?, commentaire_habitat = ?, image = ? WHERE habitat_id = ?");
        $stmt->execute([$description, $comment, $imagePath, $habitat_id]);
        header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Habitats</title>
    <link rel="stylesheet" href="../interfaces.css">
</head>
<body>
<div class="habitat-management-container">
    <h1>Gestion des Habitats</h1>
    <?php foreach ($habitats as $habitat): ?>
        <div class="habitat-card">
            <h2><?= htmlspecialchars($habitat['nom']); ?></h2>
            <img src="<?= htmlspecialchars($habitat['image']) ?>" alt="Image de <?= htmlspecialchars($habitat['nom']) ?>" class="habitat-image">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="habitat_id" value="<?= $habitat['habitat_id']; ?>">
                <label for="description_<?= $habitat['habitat_id']; ?>">Description:</label>
                <textarea id="description_<?= $habitat['habitat_id']; ?>" name="description"><?= htmlspecialchars($habitat['description']); ?></textarea><br>
                <label for="comment_<?= $habitat['habitat_id']; ?>">Commentaire:</label>
                <textarea id="comment_<?= $habitat['habitat_id']; ?>" name="comment"><?= htmlspecialchars($habitat['commentaire_habitat']); ?></textarea><br>
                <label for="image_<?= $habitat['habitat_id']; ?>">Image:</label>
                <input type="file" id="image_<?= $habitat['habitat_id']; ?>" name="image"><br>
                <button type="submit" name="update_description">Mettre à jour</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
<?php include('../footer.php'); ?>
</body>
</html>
