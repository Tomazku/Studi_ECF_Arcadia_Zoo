<?php
session_start();
include('../header.php');
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $prenom = $_POST['prenom'];
    $etat = $_POST['etat'];
    $race_id = $_POST['race_id'];
    $habitat_id = $_POST['habitat_id'];

    // Gérer le téléchargement de l'image
    $uploadDir = 'uploads/';
    $tmpName = $_FILES['image']['tmp_name'];
    $filename = basename($_FILES['image']['name']);
    $uploadFile = $uploadDir . $filename;
    

    if (move_uploaded_file($tmpName, $uploadFile)) {
        // Insertion dans la base de données
        $stmt = $pdo->prepare("INSERT INTO animal (prenom, etat, race_id, habitat_id, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$prenom, $etat, $race_id, $habitat_id, $uploadFile]);
        echo "Animal ajouté avec succès.";
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
}

// Récupérer toutes les races pour le menu déroulant
$stmt = $pdo->query("SELECT race_id, label FROM race");
$races = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les habitats pour le menu déroulant
$stmt = $pdo->query("SELECT habitat_id, nom FROM habitat");
$habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un animal</title>
    <link rel="stylesheet" href="../interfaces.css">
</head>
<body>
    <h1>Ajouter un nouvel animal</h1>
    <form method="post" enctype="multipart/form-data">
        Prénom: <input type="text" name="prenom" required><br>
        État: <select name="etat" required>
            <option value="Sain">Sain</option>
            <option value="Malade">Malade</option>
            <option value="À surveiller">À surveiller</option>
            <option value="En traitement">En traitement</option>
            <option value="Convalescent">Convalescent</option>
        </select><br>
        Race: <select name="race_id" required>
            <?php foreach ($races as $race): ?>
                <option value="<?php echo $race['race_id']; ?>">
                    <?php echo htmlspecialchars($race['label']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        Habitat: <select name="habitat_id" required>
            <?php foreach ($habitats as $habitat): ?>
                <option value="<?php echo $habitat['habitat_id']; ?>">
                    <?php echo htmlspecialchars($habitat['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        Image: <input type="file" name="image" required><br>
        <input type="submit" value="Ajouter">
    </form>
    <?php
include('../footer.php');
?>
</body>
</html>
