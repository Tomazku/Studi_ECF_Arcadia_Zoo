<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

$habitat_id = $_GET['habitat_id'] ?? 0;
$race_id = $_GET['race_id'] ?? 0;

// Récupération des données pour les filtres
$habitats = $pdo->query("SELECT habitat_id, nom FROM habitat")->fetchAll(PDO::FETCH_ASSOC);
$races = $pdo->query("SELECT race_id, label FROM race")->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT animal.animal_id, animal.prenom, animal.image, animal.etat, race.label as race, habitat.nom as habitat 
        FROM animal 
        JOIN race ON animal.race_id = race.race_id 
        JOIN habitat ON animal.habitat_id = habitat.habitat_id";

if ($habitat_id > 0 || $race_id > 0) {
    $sql .= " WHERE";
    if ($habitat_id > 0) {
        $sql .= " animal.habitat_id = :habitat_id";
    }
    if ($habitat_id > 0 && $race_id > 0) {
        $sql .= " AND";
    }
    if ($race_id > 0) {
        $sql .= " animal.race_id = :race_id";
    }
}

$stmt = $pdo->prepare($sql);

if ($habitat_id > 0) {
    $stmt->bindParam(':habitat_id', $habitat_id, PDO::PARAM_INT);
}
if ($race_id > 0) {
    $stmt->bindParam(':race_id', $race_id, PDO::PARAM_INT);
}

$stmt->execute();
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animaux du Zoo</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 1200px; margin: auto; }
        .breadcrumb { margin: 20px; }
        .breadcrumb a { color: #0275d8; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .animal-container { display: flex; flex-wrap: wrap; justify-content: space-around; }
        .animal-card { border: 1px solid #ddd; border-radius: 5px; padding: 10px; width: 30%; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; cursor: pointer; }
        .animal-card img { width: 100%; height: 200px; object-fit: cover; border-radius: 5px; }
        form { margin-top: 20px; }
        select, button { padding: 10px; margin-right: 10px; }
        .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }
        .modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 50%; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; }
        .close:hover, .close:focus { color: black; text-decoration: none; cursor: pointer; }
    </style>
    <script>
    function openModal(prenom, image, etat, race) {
        var modal = document.getElementById('myModal');
        document.getElementById('modalPrenom').textContent = prenom;
        document.getElementById('modalImage').src = image;
        document.getElementById('modalEtat').textContent = 'État: ' + etat;
        document.getElementById('modalRace').textContent = 'Race: ' + race;
        modal.style.display = "block";
    }

    function closeModal() {
        var modal = document.getElementById('myModal');
        modal.style.display = "none";
    }
    </script>
</head>
<body>
    <?php include 'assets/includes/header.php'; ?>
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Accueil</a> &gt; <a href="habitats.php">Habitats</a> &gt; Animaux
        </div>
        <h1>Animaux du Zoo</h1>
        <form action="animaux.php" method="get">
            Filtrer par Habitat:
            <select name="habitat_id">
                <option value="">Tous les habitats</option>
                <?php foreach ($habitats as $habitat): ?>
                    <option value="<?= $habitat['habitat_id'] ?>" <?= $habitat_id == $habitat['habitat_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($habitat['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            Filtrer par Race:
            <select name="race_id">
                <option value="">Toutes les races</option>
                <?php foreach ($races as $race): ?>
                    <option value="<?= $race['race_id'] ?>" <?= $race_id == $race['race_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($race['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Appliquer les filtres</button>
        </form>
        <div class="animal-container">
            <?php foreach ($animals as $animal): ?>
                <div class="animal-card" onclick="openModal('<?= htmlspecialchars($animal['prenom']) ?>', '<?= htmlspecialchars($animal['image']) ?>', '<?= htmlspecialchars($animal['etat']) ?>', '<?= htmlspecialchars($animal['race']) ?>')">
                    <img src="./pages/Back-end/animals/uploads/ htmlspecialchars($animal['image']) ?>" alt="Image of <?= htmlspecialchars($animal['prenom']) ?>">
                    <h4><?= htmlspecialchars($animal['prenom']) ?></h4>
                    <p>Race: <?= htmlspecialchars($animal['race']) ?></p>
                    <p>Habitat: <?= htmlspecialchars($animal['habitat']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="modalImage" src="" alt="" style="width: 200px; height: auto; float: left; margin-right: 20px;">
            <h2 id="modalPrenom"></h2>
            <p id="modalEtat"></p>
            <p id="modalRace"></p>
        </div>
    </div>
    <?php include 'assets/includes/footer.php'; ?>
</body>
</html>
