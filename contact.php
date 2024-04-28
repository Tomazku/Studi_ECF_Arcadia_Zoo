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
    <div class="contact_container">
        <h2>Horaires d'ouverture :</h2>
</div>

    </div>

    <div class="contact_container">
        <h1>Contactez-nous</h1>
        <form id="contactForm" action="./pages/Back-end/Connexion/Interface/traitement.php" method="POST">
    <!-- Ajoutez des champs de formulaire cachés pour les heures d'ouverture et de fermeture -->
   

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

    // Récupérer les valeurs des horaires d'ouverture depuis le formulaire de horaires.php
    var heureOuverture = document.querySelector('[name="horaires[heure_ouverture]"]').value;
    var heureFermeture = document.querySelector('[name="horaires[heure_fermeture]"]').value;

    // Mettre à jour les champs de formulaire cachés avec les valeurs récupérées
    document.getElementById('heure_ouverture').value = heureOuverture;
    document.getElementById('heure_fermeture').value = heureFermeture;

    // Soumettre le formulaire de contact avec les données des horaires d'ouverture
    this.submit();
});
</script>
</body>
</html>


   