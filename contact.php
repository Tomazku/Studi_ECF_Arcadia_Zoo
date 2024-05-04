<?php
require_once('./pages/Back-end/horaires/fonctions_horaires.php'); // Inclure le fichier de fonctions pour les horaires
$horaires = getHorairesOuverture(); // Récupérer les horaires d'ouverture depuis la base de données
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restons en contact - Arcadia Zoo</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">
</head>
<body>
    <?php include 'assets/includes/header.php'; ?>
    <div class="contact_container">
        <h2>Horaires d'ouverture :</h2>
    </div>

    <div class="contact_container">
        <h1>Contactez-nous</h1>
        <form id="contactForm" action="./pages/Back-end/Connexion/Interface/traitement.php" method="POST">
            <!-- Ajoutez des champs de formulaire cachés pour les heures d'ouverture et de fermeture -->
            <?php foreach ($horaires as $horaire) : ?>
                <input type="hidden" name="horaires[<?= $horaire['horaires_id'] ?>][heure_ouverture]" value="<?= $horaire['heure_ouverture'] ?>">
                <input type="hidden" name="horaires[<?= $horaire['horaires_id'] ?>][heure_fermeture]" value="<?= $horaire['heure_fermeture'] ?>">
            <?php endforeach; ?>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message :</label>
            <textarea id="message" name="message" required></textarea>

            <button id="submitBtn" class="button" type="submit">Envoyer</button>
        </form>
        <div id="confirmationMessage" style="display: none;">
            Votre message a été envoyé avec succès!
        </div>
    </div> 
    <?php include 'assets/includes/footer.php'; ?>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêcher l'envoi du formulaire par défaut

            // Soumettre le formulaire de contact avec les données des horaires d'ouverture
            this.submit();
        });
    </script>
</body>
</html>
