<?php

require_once('auth.php');
require_once('./fonctions_horaires.php');

// Vérifier si le formulaire de mise à jour des horaires a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $jour = $_POST["jour"];
    $ferme = isset($_POST["ferme"]); // Vérifier si le jour est fermé
    $heure_ouverture = $_POST["heure_ouverture"];
    $heure_fermeture = $_POST["heure_fermeture"];

    // Mettre à jour les horaires d'ouverture dans la base de données
    updateHorairesOuverture($jour, $ferme, $heure_ouverture, $heure_fermeture);
}

// Récupérer les horaires d'ouverture depuis la base de données
$horaires = getHorairesOuverture();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-end - Gestion des horaires d'ouverture</title>
</head>
<body>
    <h1>Gestion des horaires d'ouverture</h1>

    <form method="POST">
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
                    <td><?= $horaire['fermé'] ? 'Fermé' : 'Ouvert' ?></td>
                    <td><input type="time" name="heure_ouverture" value="<?= $horaire['heure_ouverture'] ?>"></td>
                    <td><input type="time" name="heure_fermeture" value="<?= $horaire['heure_fermeture'] ?>"></td>
                    <td>
                        <input type="checkbox" name="ferme" <?= $horaire['fermé'] ? 'checked' : '' ?>> Fermé
                        <button type="submit">Enregistrer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </form>
</body>
</html>
