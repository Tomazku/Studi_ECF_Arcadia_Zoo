<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

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
</head>
<body>
<h1>Gestion des Habitats</h1>
<?php foreach ($habitats as $habitat): ?>
    <div>
        <h2><?= htmlspecialchars($habitat['nom']); ?></h2>
        <img src="<?= htmlspecialchars($habitat['image']) ?>" alt="Image de <?= htmlspecialchars($habitat['nom']) ?>" style="width:200px;">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="habitat_id" value="<?= $habitat['habitat_id']; ?>">
            Description: <textarea name="description"><?= htmlspecialchars($habitat['description']); ?></textarea><br>
            Commentaire: <textarea name="comment"><?= htmlspecialchars($habitat['commentaire_habitat']); ?></textarea><br>
            Image: <input type="file" name="image"><br>
            <button type="submit" name="update_description">Mettre à jour</button>
        </form>
    </div>
<?php endforeach; ?>
</body>
</html>
