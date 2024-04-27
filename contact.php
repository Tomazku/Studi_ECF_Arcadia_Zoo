<?php
require_once('./pages/Back-end/Connexion/Interface/fonctions_horaires.php');

//récupération des horaires depuis la base de données
$horaires = getHorairesOuverture();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Découvrez le zoo Arcadia</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">
</head>

<body>
    <?php include 'assets/includes/header.php'; ?>
    <div class="contact_container">
        <h2>Horaires d'ouverture :</h2>
        <ul>
            <!-- Ici seront affichés dynamiquement les horaires d'ouverture -->
        </ul>
    </div>

    <div class="contact_container">
        <h1>Contactez-nous</h1>
        <form id="contactForm" action="./pages/Back-end/Connexion/Interface/traitement.php" method="POST">
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

            // Masquer le formulaire
            document.getElementById('contactForm').style.display = 'none';
            
            // Afficher le message de confirmation
            document.getElementById('confirmationMessage').style.display = 'block';
        });
    </script>
</body>
</html>
