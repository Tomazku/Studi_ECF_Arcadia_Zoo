<?php
require_once('fonctions_horaires.php');
require_once('auth.php');

// Récupérer les horaires depuis la base de données
$horaires = getHorairesOuverture();

// Vérifier si le formulaire de mise à jour des horaires a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous de traiter la soumission du formulaire ici
    // Par exemple, vous pouvez appeler une fonction pour mettre à jour les horaires
    updateHoraires($_POST['horaires']);

    // Envoyer une réponse JSON pour indiquer que la mise à jour a réussi
    echo json_encode(["success" => true, "message" => "Les horaires ont été mis à jour avec succès"]);
    exit; // Arrêter l'exécution du script immédiatement après avoir envoyé la réponse
}

// Récupérer à nouveau les horaires après éventuelle mise à jour
$horaires = getHorairesOuverture();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-end - Gestion des horaires d'ouverture</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
    <!-- Menu de navigation vertical fixe -->
    <nav class="sidebar">
        <ul>
            <li><a href="#">ajout utilisateur</a></li>
            <li><a href="#">Gestion des utilisateurs</a></li>
            <li><a href="#">Gestion des animaux</a></li>
            <li><a href="./horaires.php">Gestion des horaires</a></li>
            <!-- Ajoutez d'autres liens de navigation ici -->
        </ul>
    </nav>
    <div class="content">
        <header>
            <h1>Gestion des horaires d'ouverture</h1>
        </header>

        <form id="horairesForm" method="POST">
            <table>
                <tr>
                    <th>Jour</th>
                    <th>Ouvert</th>
                    <th>Heure d'ouverture</th>
                    <th>Heure de fermeture</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($horaires as $horaire) : ?>
                    <tr>
                        <td><?= $horaire['jour'] ?></td>
                        <td><?= $horaire['heure_ouverture'] && $horaire['heure_fermeture'] ? 'Ouvert' : 'Fermé' ?></td>
                        <td><input type="time" name="horaires[<?= $horaire['horaire_id'] ?>][heure_ouverture]" value="<?= $horaire['heure_ouverture'] ?>"></td>
                        <td><input type="time" name="horaires[<?= $horaire['horaire_id'] ?>][heure_fermeture]" value="<?= $horaire['heure_fermeture'] ?>"></td>
                        <td>
                            <input type="checkbox" name="horaires[<?= $horaire['horaire_id'] ?>][ferme]" <?= !$horaire['heure_ouverture'] && !$horaire['heure_fermeture'] ? 'checked' : '' ?>> Fermé
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <button type="submit">Enregistrer</button>
        </form>
    </div>
    <!-- Afficher une popup de confirmation -->
    <div id="confirmationMessage" style="display: none;">Les horaires ont été mis à jour avec succès</div>
    <script>
        document.getElementById('horairesForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêcher l'envoi du formulaire par défaut

            // Envoyer les données du formulaire en AJAX
            var formData = new FormData(this);
            fetch('horaires.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Afficher le message de confirmation
                    document.getElementById('confirmationMessage').style.display = 'block';
                } else {
                    // Afficher une erreur si la requête a échoué
                    alert('Une erreur s\'est produite. Veuillez réessayer.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur s\'est produite. Veuillez réessayer.');
            });
        });
    </script>
</body>
</html>
