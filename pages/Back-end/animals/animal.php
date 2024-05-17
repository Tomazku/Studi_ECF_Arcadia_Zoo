<?php
include('../header.php');
include('pdo.php');

// Fonction pour récupérer le nombre de consultations
function getConsultations($animalName) {
    $filePath = "./noSQL/nview_animal.json";
    if (!file_exists($filePath)) {
        return 0;
    }
    $fileContent = file_get_contents($filePath);
    $data = json_decode($fileContent, true);
    return isset($data[$animalName]) ? $data[$animalName] : 0;
}

// Gérer les requêtes POST pour l'ajout, la modification des animaux et des rapports, et la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajouter un rapport vétérinaire
    if (isset($_POST['ajouter_rapport'])) {
        $animal_id = $_POST['animal_id'];
        $date = date('Y-m-d');
        $detail = $_POST['detail'];
        $stmt = $pdo->prepare("INSERT INTO rapport_veterinaire (animal_id, date, detail) VALUES (?, ?, ?)");
        $stmt->execute([$animal_id, $date, $detail]);
        $successMessage = "Rapport vétérinaire ajouté.";
    } elseif (isset($_POST['supprimer_animal'])) {
        // Suppression d'un animal
        $animal_id = $_POST['animal_id'];
        $stmt = $pdo->prepare("DELETE FROM animal WHERE animal_id = ?");
        $stmt->execute([$animal_id]);
        $successMessage = "Animal supprimé avec succès.";
    } elseif (isset($_POST['modifier_animal'])) {
        // Modification d'un animal
        $animal_id = $_POST['animal_id'];
        $prenom = $_POST['prenom'];
        $etat = $_POST['etat'];
        $race_id = $_POST['race_id'];
        $habitat_id = $_POST['habitat_id'];

        $stmt = $pdo->prepare("UPDATE animal SET prenom = ?, etat = ?, race_id = ?, habitat_id = ? WHERE animal_id = ?");
        $stmt->execute([$prenom, $etat, $race_id, $habitat_id, $animal_id]);

        $successMessage = "Informations de l'animal mises à jour.";
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
$sql = "SELECT animal.animal_id, animal.prenom, animal.etat, animal.image, race.label as race, habitat.nom as habitat, habitat.commentaire_habitat FROM animal JOIN race ON animal.race_id = race.race_id JOIN habitat ON animal.habitat_id = habitat.habitat_id";
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
    <div class="animal-management-container">
        <h1>Gestion des Animaux</h1>
        <form class="filter-form" method="get">
            <label for="filter_nom">Filtrer par Nom:</label>
            <input type="text" id="filter_nom" name="filter_nom"><br>

            <label for="filter_race">Filtrer par Race:</label>
            <select id="filter_race" name="filter_race">
                <option value="">Sélectionnez une race</option>
                <?php foreach ($races as $race) { echo "<option value='{$race['race_id']}'>{$race['label']}</option>"; } ?>
            </select><br>

            <label for="filter_habitat">Filtrer par Habitat:</label>
            <select id="filter_habitat" name="filter_habitat">
                <option value="">Sélectionnez un habitat</option>
                <?php foreach ($habitats as $habitat) { echo "<option value='{$habitat['habitat_id']}'>{$habitat['nom']}</option>"; } ?>
            </select><br>

            <button type="submit">Appliquer le filtre</button>
            <button type="button" onclick="window.location='animal.php';">Réinitialiser les filtres</button>
        </form>

        <?php if (isset($successMessage)): ?>
            <p class="success-message"><?= htmlspecialchars($successMessage); ?></p>
        <?php endif; ?>

        <h2>Liste des Animaux</h2>
        <div class="animal-list">
            <?php foreach ($animals as $animal): ?>
                <div class="animal-card">
                    <img src="./<?= htmlspecialchars($animal['image']) ?>" alt="Image" class="animal-image"><br>
                    <strong><?= htmlspecialchars($animal['prenom']) ?></strong><br>
                    <span>État: <?= htmlspecialchars($animal['etat']) ?></span><br>
                    <span>Race: <?= htmlspecialchars($animal['race']) ?></span><br>
                    <span>Habitat: <?= htmlspecialchars($animal['habitat']) ?></span><br>
                    <span>Commentaire: <?= htmlspecialchars($animal['commentaire_habitat']) ?></span><br>
                    <span>Consultations: <?= getConsultations(htmlspecialchars($animal['prenom']) . "_" . htmlspecialchars($animal['animal_id'])) ?> fois</span><br>

                    <form class="edit-form" method="post">
                        <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>">
                        <label for="prenom_<?= $animal['animal_id'] ?>">Prénom:</label>
                        <input type="text" id="prenom_<?= $animal['animal_id'] ?>" name="prenom" value="<?= htmlspecialchars($animal['prenom']) ?>" required><br>

                        <label for="etat_<?= $animal['animal_id'] ?>">État:</label>
                        <input type="text" id="etat_<?= $animal['animal_id'] ?>" name="etat" value="<?= htmlspecialchars($animal['etat']) ?>" required><br>

                        <label for="race_id_<?= $animal['animal_id'] ?>">Race:</label>
                        <select id="race_id_<?= $animal['animal_id'] ?>" name="race_id">
                            <?php foreach ($races as $race) {
                                $selected = ($race['race_id'] == $animal['race_id']) ? 'selected' : '';
                                echo "<option value='{$race['race_id']}' $selected>{$race['label']}</option>";
                            } ?>
                        </select><br>

                        <label for="habitat_id_<?= $animal['animal_id'] ?>">Habitat:</label>
                        <select id="habitat_id_<?= $animal['animal_id'] ?>" name="habitat_id">
                            <?php foreach ($habitats as $habitat) {
                                $selected = ($habitat['habitat_id'] == $animal['habitat_id']) ? 'selected' : '';
                                echo "<option value='{$habitat['habitat_id']}' $selected>{$habitat['nom']}</option>";
                            } ?>
                        </select><br>

                        <button type="submit" name="modifier_animal">Modifier</button>
                    </form>

                    <form class="report-form" method="post">
                        <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>">
                        <textarea name="detail" placeholder="Détails du rapport vétérinaire" required></textarea><br>
                        <button type="submit" name="ajouter_rapport">Ajouter rapport</button>
                    </form>

                    <div class="rapport-container">
                        <h3>Rapports Vétérinaires</h3>
                        <?php
                        $stmt = $pdo->prepare("SELECT date, detail FROM rapport_veterinaire WHERE animal_id = ?");
                        $stmt->execute([$animal['animal_id']]);
                        $rapports = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($rapports as $rapport): ?>
                            <div class="rapport-card">
                                <strong>Date: <?= htmlspecialchars($rapport['date']) ?></strong><br>
                                <p><?= htmlspecialchars($rapport['detail']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <form class="delete-form" method="post">
                        <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>">
                        <button type="submit" name="supprimer_animal">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include('../footer.php'); ?>
</body>
</html>
