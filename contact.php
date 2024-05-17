
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
    <?php include 'assets/includes/header.php'; ?>
    <div class="container-breadcrumb">
        <div class="breadcrumb">
            <a href="index.php">Accueil</a> &gt; <a href="contact.php">Contact</a>
        </div>
    </div>
<body>
    <div class="container_contact">
        <div class="container_gauche">
            <img id="image_contact" src="./assets/images/contact.jpg" alt="Image de contact">
        </div>
        <div class="container_droite">
            <form id="contactForm" action="../Studi_ECF_Arcadia_Zoo/pages/Back-end/contact_BG.php" method="post">
                <h2>Restons en <span class="orange-text">contact</span></h2>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required><br><br>

                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required><br><br>

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
    <div><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d50885.629868508164!2d4.994167828339651!3d47.910332913384075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2spl!4v1715422819287!5m2!1sfr!2spl" width="100%" height="400px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>

    <?php include 'assets/includes/footer.php'; ?>

    <script>
        document.getElementById("contactForm").addEventListener("submit", function (event) {
    event.preventDefault();

    fetch("../Studi_ECF_Arcadia_Zoo/pages/Back-end/contact_BG.php", {
        method: "POST",
        body: new FormData(this)
    })
        .then(response => {
            if (response.ok) {
                alert("Votre message a été envoyé avec succès !");
                document.getElementById("contactForm").reset();
            } else {
                console.error("Erreur : " + response.status + " " + response.statusText);
            }
        })
        .catch(error => console.error("Erreur lors de l'envoi du formulaire:", error));
});
    </script>
</body>
</html>
