<?php include 'assets/includes/header.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restons en contact - Arcadia Zoo</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="shortcut icon" href="/assets/images/fav_icon.png" type="image/x-icon">
</head>
<body>
    <div class="container_contact">
        <div class="container_gauche">
            <img id="image_contact" src="./assets/images/contact.jpg" alt="Image de contact">
        </div>
        <div class="container_droite">
            <form id="contactForm" action="/" method="post">
                <h2>Restons en <span class="orange-text">contact</span></h2>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required><br><br>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required><br><br>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="messages">Message :</label><br>
                <textarea id="messages" name="message" rows="10" cols="50" required></textarea><br><br>

                <input class="button" type="submit" value="Envoyer">
            </form>
            <div id="successMessage" style="display: none;">Votre message a été envoyé avec succès !
        </div>

        </div>
    </div>
    <?php include 'assets/includes/footer.php'; ?>

    <script>
        // Fonction appelée lors de la soumission du formulaire
        document.getElementById("contactForm").addEventListener("submit", function(event) {
    // Empêche l'envoi par défaut du formulaire
    event.preventDefault();

    // Envoie les données via fetch
    fetch("contact.php", {
        method: "POST",
        body: new FormData(this)
    })
    .then(response => {
        if (response.ok) {
            // Affiche le message de succès
            document.getElementById("successMessage").style.display = "block";
        }
    })
    .catch(error => console.error("Erreur lors de l'envoi du formulaire:", error));
});
    </script>
</body>
</html>
