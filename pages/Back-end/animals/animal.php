<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Gérer les requêtes POST pour l'ajout et la modification des animaux et des rapports
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajouter ou modifier des informations sur les animaux
    
    // Ajouter un rapport vétérinaire
    if (isset($_POST['ajouter_rapport'])) {
        $animal_id = $_POST['animal_id'];
        $date = date('Y-m-d'); // Date actuelle
        $detail = $_POST['detail'];
        $stmt = $pdo->prepare("INSERT INTO rapport_veterinaire (animal_id, date, detail) VALUES (?, ?, ?)");
        $stmt->execute([$animal_id, $date, $detail]);
        echo "<p>Rapport vétérinaire ajouté.</p>";
    }
}

// Récupérer les informations pour les listes déroulantes
$stmt = $pdo->query("SELECT race_id, label FROM race");
$races = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->query("SELECT habitat_id, nom FROM habitat");
$habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Construire la requête avec des conditions de filtrage
$where = [];
$params = [];
if (!empty($_GET['filter_nom'])) {
    $where[] = "animal.prenom LIKE ?";
    $params[] = '%' . $_GET['filter_nom'] . '%';
}
if (!empty($_GET['filter_race'])) {
    $where[] = "animal.race_id = ?";
    $params[] = $_GET['filter_race'];
}
if (!empty($_GET['filter_habitat'])) {
    $where[] = "animal.habitat_id = ?";
    $params[] = $_GET['filter_habitat'];
}
$sql = "SELECT animal.animal_id, animal.prenom, animal.etat, animal.image, race.label as race, habitat.nom as habitat FROM animal JOIN race ON animal.race_id = race.race_id JOIN habitat ON animal.habitat_id = habitat.habitat_id";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Animaux</title>
</head>
<body>
    <h1>Gestion des Animaux</h1>

    <form method="get">
        Filtrer par Nom: <input type="text" name="filter_nom"><br>
        Filtrer par Race: <select name="filter_race">
            <option value="">Sélectionnez une race</option>
            <?php foreach ($races as $race) { echo "<option value='{$race['race_id']}'>{$race['label']}</option>"; } ?>
        </select><br>
        Filtrer par Habitat: <select name="filter_habitat">
            <option value="">Sélectionnez un habitat</option>
            <?php foreach ($habitats as $habitat) { echo "<option value='{$habitat['habitat_id']}'>{$habitat['nom']}</option>"; } ?>
        </select><br>
        <button type="submit">Appliquer le filtre</button>
    </form>

    <h2>Liste des Animaux</h2>
    <?php foreach ($animals as $animal): ?>
        <div>
            <img src="uploads/<?= htmlspecialchars($animal['image']) ?>" alt="Image" style="width:100px;"><br>
            <strong><?= htmlspecialchars($animal['prenom']) ?></strong><br>
            État: <?= htmlspecialchars($animal['etat']) ?><br>
            Race: <?= htmlspecialchars($animal['race']) ?><br>
            Habitat: <?= htmlspecialchars($animal['habitat']) ?><br>
            <!-- Formulaire pour ajouter un rapport vétérinaire -->
            <form method="post">
                <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>">
                <textarea name="detail" placeholder="Détails du rapport vétérinaire" required></textarea><br>
                <button type="submit" name="ajouter_rapport">Ajouter rapport</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
