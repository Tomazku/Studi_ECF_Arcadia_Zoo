<?php
session_start();
include('../header.php');

$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Gérer les requêtes POST pour l'ajout, la modification des animaux et des rapports, et la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajouter un rapport vétérinaire
    if (isset($_POST['ajouter_rapport'])) {
        $animal_id = $_POST['animal_id'];
        $date = date('Y-m-d');
        $detail = $_POST['detail'];
        $stmt = $pdo->prepare("INSERT INTO rapport_veterinaire (animal_id, date, detail) VALUES (?, ?, ?)");
        $stmt->execute([$animal_id, $date, $detail]);
        echo "<p>Rapport vétérinaire ajouté.</p>";
    } elseif (isset($_POST['supprimer_animal'])) {
        // Suppression d'un animal
        $animal_id = $_POST['animal_id'];
        $stmt = $pdo->prepare("DELETE FROM animal WHERE animal_id = ?");
        $stmt->execute([$animal_id]);
        echo "<p>Animal supprimé avec succès.</p>";
    } elseif (isset($_POST['modifier_animal'])) {
        // Modification d'un animal
        $animal_id = $_POST['animal_id'];
        $prenom = $_POST['prenom'];
        $etat = $_POST['etat'];
        $race_id = $_POST['race_id'];
        $habitat_id = $_POST['habitat_id'];

        $stmt = $pdo->prepare("UPDATE animal SET prenom = ?, etat = ?, race_id = ?, habitat_id = ? WHERE animal_id = ?");
        $stmt->execute([$prenom, $etat, $race_id, $habitat_id, $animal_id]);

        echo "<p>Informations de l'animal mises à jour.</p>";
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
    <link rel="stylesheet" href="../interfaces.css">
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
        <button type="button" onclick="window.location='animal.php';">Réinitialiser les filtres</button>
    </form>

    <h2>Liste des Animaux</h2>
    <?php foreach ($animals as $animal): ?>
        <div>
            <img src="./<?= htmlspecialchars($animal['image']) ?>" alt="Image" style="width:100px;"><br>
            <strong><?= htmlspecialchars($animal['prenom']) ?></strong><br>
            État: <?= htmlspecialchars($animal['etat']) ?><br>
            Race: <?= htmlspecialchars($animal['race']) ?><br>
            Habitat: <?= htmlspecialchars($animal['habitat']) ?><br>
            <form method="post">
                <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>">
                Prénom: <input type="text" name="prenom" value="<?= htmlspecialchars($animal['prenom']) ?>" required><br>
                État: <input type="text" name="etat" value="<?= htmlspecialchars($animal['etat']) ?>" required><br>
                Race: <select name="race_id">
                    <?php foreach ($races as $race) {
                        $selected = ($race['race_id'] == $animal['race_id']) ? 'selected' : '';
                        echo "<option value='{$race['race_id']}' $selected>{$race['label']}</option>";
                    } ?>
                </select><br>
                Habitat: <select name="habitat_id">
                    <?php foreach ($habitats as $habitat) {
                        $selected = ($habitat['habitat_id'] == $animal['habitat_id']) ? 'selected' : '';
                        echo "<option value='{$habitat['habitat_id']}' $selected>{$habitat['nom']}</option>";
                    } ?>
                </select><br>
                <button type="submit" name="modifier_animal">Modifier</button>
            </form>
            <form method="post">
                <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>">
                <textarea name="detail" placeholder="Détails du rapport vétérinaire" required></textarea><br>
                <button type="submit" name="ajouter_rapport">Ajouter rapport</button>
            </form>
            <!-- Ajout du formulaire de suppression -->
            <form method="post">
                <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>">
                <button type="submit" name="supprimer_animal">Supprimer</button>
            </form>
        </div>
    <?php endforeach; 
    include('../footer.php');
    ?>
    </body>
</html>

