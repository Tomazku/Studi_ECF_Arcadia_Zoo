<?php
// Inclure le fichier de connexion à la base de données et les fonctions pour les horaires
require_once('fonctions_horaires.php');
require_once('auth.php');

// Définir les jours de la semaine
$joursSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

// Récupérer les horaires depuis la base de données
$horaires = getHorairesOuverture();

// Initialisez une variable pour suivre si la mise à jour a été réussie ou non
$updateSuccess = false;

// Vérifier si le formulaire de mise à jour des horaires a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Traiter la soumission du formulaire
    if (isset($_POST['horaires'])) {
        updateHoraires($_POST['horaires']);
        $updateSuccess = true;
    }
    
    // Vérifier si de nouveaux horaires ont été ajoutés
    if (isset($_POST['nouveaux_horaires'])) {
        insertNouveauxHoraires($_POST['nouveaux_horaires']);
        $updateSuccess = true;
    }

    // Récupérer à nouveau les horaires après mise à jour
    $horaires = getHorairesOuverture();

    // Envoyer une réponse JSON pour indiquer que la mise à jour a réussi
    header('Content-Type: application/json');
    echo json_encode(["success" => $updateSuccess, "horaires" => $horaires]);
    exit; // Arrêter l'exécution du script
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-end - Gestion des horaires d'ouverture</title>
    <link rel="stylesheet" href="../interfaces.css">
</head>
<body>
    <nav class="sidebar">
        <ul>
            <li><a href="#">ajout utilisateur</a></li>
            <li><a href="#">Gestion des utilisateurs</a></li>
            <li><a href="#">Gestion des animaux</a></li>
            <li><a href="./horaires.php">Gestion des horaires</a></li>
            <li><a href="../avis/administration_avis.php">Gestion des avis</a></li>
        </ul>
    </nav>
    <div class="content">
        <header>
            <h1>Gestion des horaires d'ouverture</h1>
        </header>

        <form method="POST" action="horaires.php">
            <table>
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Heure d'ouverture</th>
                        <th>Heure de fermeture</th>
                        <th>Fermé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($joursSemaine as $jour) : ?>
                        <?php $horaire = $horaires[$jour] ?? null; ?>
                        <tr>
                            <td><?= $jour ?></td>
                            <td><input type="time" name="horaires[<?= $jour ?>][heure_ouverture]" value="<?= $horaire ? date('H:i', strtotime($horaire['heure_ouverture'])) : '' ?>"></td>
                            <td><input type="time" name="horaires[<?= $jour ?>][heure_fermeture]" value="<?= $horaire ? date('H:i', strtotime($horaire['heure_fermeture'])) : '' ?>"></td>
                            <td><input type="checkbox" name="horaires[<?= $jour ?>][ferme]" <?= $horaire && $horaire['ferme'] ? 'checked' : '' ?>></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit">Enregistrer les modifications</button>
        </form>

        <h2>Horaires actuels validés</h2>
        <table>
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Heure d'ouverture</th>
                    <th>Heure de fermeture</th>
                    <th>Fermé</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horaires as $jour => $horaire) : ?>
                    <tr>
                        <td><?= $jour ?></td>
                        <td><?= $horaire['heure_ouverture'] ? date('H:i', strtotime($horaire['heure_ouverture'])) : '—' ?></td>
                        <td><?= $horaire['heure_fermeture'] ? date('H:i', strtotime($horaire['heure_fermeture'])) : '—' ?></td>
                        <td><?= $horaire['ferme'] ? 'Oui' : 'Non' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        document.forms[0].addEventListener('submit', function(event) {
            event.preventDefault();
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      alert('Horaires mis à jour avec succès.');
                      location.reload(); // Recharger la page pour voir les modifications
                  } else {
                      alert('Erreur lors de la mise à jour des horaires.');
                  }
              })
              .catch(error => { 
                  console.error('Error:', error);
                  alert('Une erreur réseau s\'est produite. Veuillez réessayer.');
              });
        });
    </script>
</body>
</html>
