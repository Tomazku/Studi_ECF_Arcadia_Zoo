<?php
session_start();
include('../header.php');
include('../pdo.php');

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
        $successMessage = "Animal ajouté avec succès.";
    } else {
        $errorMessage = "Erreur lors du téléchargement de l'image.";
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
    <div class="add-animal-container">
        <h1>Ajouter un nouvel animal</h1>
        <form class="add-animal-form" method="post" enctype="multipart/form-data">
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="etat">État:</label>
            <select id="etat" name="etat" required>
                <option value="Sain">Sain</option>
                <option value="Malade">Malade</option>
                <option value="À surveiller">À surveiller</option>
                <option value="En traitement">En traitement</option>
                <option value="Convalescent">Convalescent</option>
            </select>

            <label for="race_id">Race:</label>
            <select id="race_id" name="race_id" required>
                <?php foreach ($races as $race): ?>
                    <option value="<?php echo $race['race_id']; ?>">
                        <?php echo htmlspecialchars($race['label']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="habitat_id">Habitat:</label>
            <select id="habitat_id" name="habitat_id" required>
                <?php foreach ($habitats as $habitat): ?>
                    <option value="<?php echo $habitat['habitat_id']; ?>">
                        <?php echo htmlspecialchars($habitat['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" required>

            <input type="submit" value="Ajouter">
        </form>
        <?php if (isset($successMessage)): ?>
            <p class="success-message"><?= htmlspecialchars($successMessage); ?></p>
        <?php endif; ?>
        <?php if (isset($errorMessage)): ?>
            <p class="error-message"><?= htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
    </div>
    <?php
    include('../footer.php');
    ?>
</body>
</html>
