<?php
// Connexion à la base de données (à adapter selon vos paramètres)
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Traitement de l'avis soumis depuis le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez d'abord que les données du formulaire existent et ne sont pas vides
    if (isset($_POST['pseudo'], $_POST['commentaire']) && !empty($_POST['pseudo']) && !empty($_POST['commentaire'])) {
        // Récupérez les données du formulaire
        $pseudo = $_POST['pseudo'];
        $commentaire = $_POST['commentaire'];

        // Préparez la requête SQL pour insérer l'avis dans la base de données
        $query = "INSERT INTO avis (pseudo, commentaire, isVisible) VALUES (:pseudo, :commentaire, 0)";
        $statement = $pdo->prepare($query);

        // Exécutez la requête SQL en liant les valeurs des paramètres
        $statement->execute(array(':pseudo' => $pseudo, ':commentaire' => $commentaire));

        // Afficher une boîte de dialogue modale (popup) après la soumission du formulaire
        echo "<script>
                if (confirm('Votre avis a été soumis avec succès. Il est en cours de validation.')) {
                    window.location.href = 'avis.php'; // Actualiser la page pour afficher les avis mis à jour
                }
            </script>";
    } else {
        // Si des données sont manquantes, vous pouvez gérer le cas ici
        echo "Erreur : Tous les champs du formulaire doivent être remplis.";
    }
}

// Récupération des avis visibles
$query_visibles = "SELECT * FROM avis WHERE isVisible = 1";
$statement_visibles = $pdo->query($query_visibles);
$avis_visibles = $statement_visibles->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laisser un avis</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">
</head>
<body>
    <?php include 'assets/includes/header.php'; ?>
    <h1 class="titre_avis">Laisser un <span class="orange-text">avis</span></h1>
    <div class="container_form_avis">
    <form id="avisForm" action="avis.php" method="POST" class="avis_form">
        <label for="pseudo" class="avis_pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required><br><br>
        <label for="commentaire" class="avis_commentaire">Commentaire :</label><br>
        <textarea id="commentaire" name="commentaire" rows="4" cols="50" required></textarea><br><br>
        <button type="submit" class="button">Soumettre l'avis</button>
    </form>
    </div>
    <section class="avis_confirmed">
        <div class="container_avis">
            <h1 class="title">Ce qu'ils <span class="orange-text">disent de nous</span></h1>
            <p>Les visiteurs du Zoo Arcadia partagent leur expérience inoubliable et leurs moments magiques passés au zoo.</p>
            <ul class="avis_container">
                <?php foreach ($avis_visibles as $avis) : ?>
                    <li class="avis"><strong><?= $avis['pseudo'] ?>:</strong> <?= $avis['commentaire'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php include 'assets/includes/footer.php'; ?>

    <script>
        // Afficher une boîte de dialogue modale (popup) après la soumission du formulaire
        document.getElementById('avisForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêcher l'envoi du formulaire par défaut
            document.getElementById('avisForm').submit(); // Soumettre le formulaire
        });
    </script>

</body>
</html>
