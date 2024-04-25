<?php
require('fonctions_horaires.php');
require_once('auth.php');

// Vérifier si le formulaire de mise à jour des horaires a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire et mettre à jour les horaires
    // ...
}

// Récupérer les horaires depuis la base de données
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
            <li><a href="#">Tableau de bord</a></li>
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
        <?php foreach ($horaires as $horaire) : ?>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $horaire['id'] ?>">
                <table>
                    <tr>
                        <th>Jour</th>
                        <th>Ouvert</th>
                        <th>Heure d'ouverture</th>
                        <th>Heure de fermeture</th>
                        <th>Actions</th>
                    </tr>
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
                </table>
            </form>
        <?php endforeach; ?>
    </div>
</body>
</html>
