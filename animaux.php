<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

$habitat_id = $_GET['habitat_id'] ?? 0;
$race_id = $_GET['race_id'] ?? 0;

$baseImagePath = "./pages/Back-end/animals/";

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
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">
    <style>
        
    </style>
    <script>
function openModal(prenom, image, etat, race, animal_id) {
    var modal = document.getElementById('myModal');
    document.getElementById('modalPrenom').textContent = prenom;
    document.getElementById('modalImage').src = image;
    document.getElementById('modalEtat').textContent = 'État: ' + etat;
    document.getElementById('modalRace').textContent = 'Race: ' + race;
    modal.style.display = "block";

    // Envoi de la requête pour incrémenter les consultations
    incrementConsultations(prenom + "_" + animal_id);
	
}

// Envoi la requête pour récupérer les consultations
function incrementConsultations(animalName) {

	formData = new FormData();
	formData.append("typeForm", "incrementation");
	formData.append("nameAnimal", animalName);

	fetch('./httpr.php', {
		method: "POST",
		body: formData,
	}) 
	.then(resultData => resultData.text())
	.then(resultData => {
		
		console.log(resultData);
		
		document.getElementById('modalConsultations').textContent = 'Consultations: ' + resultData;
			
	})
	.catch(err => console.log(err));
		
}

function closeModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = "none";
}
</script>

</head>
<body>
    <?php include 'assets/includes/header.php'; ?>
    <div class="container-breadcrumb">
        <div class="breadcrumb">
            <a href="index.php">Accueil</a> &gt; <a href="habitats.php">Habitats</a> &gt; Animaux
        </div>
    </div>
    <div class="slider-animaux">
    </div>
        <h1 class="title-animaux"><span class="orange-text">Animaux</span> du Zoo</h1>
        <form class="filtre-animaux" action="animaux.php" method="get">
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
            <button class="button" type="submit">Appliquer les filtres</button>
        </form>
        <div class="animal-container">
            <?php if (!empty($animals) && is_array($animals)): ?>
                <?php foreach ($animals as $animal): ?>
                    <div class="animal-card" onclick="openModal('<?= htmlspecialchars($animal['prenom']) ?>', '<?= $baseImagePath . htmlspecialchars($animal['image']) ?>', '<?= htmlspecialchars($animal['etat']) ?>', '<?= htmlspecialchars($animal['race']) ?>', '<?= htmlspecialchars($animal['animal_id']) ?>')">
                        <img class="img-animal" src="<?= $baseImagePath . htmlspecialchars($animal['image']) ?>" alt="Image of <?= htmlspecialchars($animal['prenom']) ?>">
                        <h4><?= htmlspecialchars($animal['prenom']) ?></h4>
                        <p>Race: <?= htmlspecialchars($animal['race']) ?></p>
                        <p>Habitat: <?= htmlspecialchars($animal['habitat']) ?></p>
                    </div>
                <?php endforeach; ?>					
            <?php else: ?>
                <p>Aucun animal trouvé.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Fenêtre modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="modalImage" class="img-modal-animal" src="" alt="">
            <h2 id="modalPrenom"></h2>
            <p id="modalEtat"></p>
            <p id="modalRace"></p>
            <p id="modalConsultations">Consultations : chargement...</p>  
        </div>
    </div>
    <?php include 'assets/includes/footer.php'; ?>
</body>
<script src="hamburger.js"></script>
<script>
    // Fonction pour fermer la modale
    function closeModal(){
        document.getElementById('myModal').style.display = 'none';
    }

    // Fermer la modale au clic en dehors de celle-ci //
    window.onclick = function(event){
        const modal = document.getElementById('myModal');
        if(event.target == modal){
            closeModal();
        }
    }
    </script>


</html>
