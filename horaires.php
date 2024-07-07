<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horaires du Zoo Arcadia</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">
</head>
<body>
    <?php include 'assets/includes/header.php'; ?>
    <div class="container-breadcrumb">
        <div class="breadcrumb">
            <a href="index.php">Accueil</a> &gt; <a href="horaires.php">Horaires</a>
        </div>
    </div>
        <h1 class="horaire-title">Horaires <span class="orange-text"> d'Ouverture</span></h1>
    <p class="text_horaires">À l'Arcadia Zoo, nous sommes ravis de vous accueillir tout au long de l'année et offrons des horaires d'ouverture adaptés pour garantir une expérience inoubliable à tous nos visiteurs. <strong>Nos portes sont ouvertes du lundi de 12h à 18h, du mardi au vendredi de 10h à 19h et le samedi de 9h à 19h</strong>. Pendant les vacances scolaires et les jours fériés, nous ajustons nos horaires pour mieux vous servir, avec des informations détaillées disponibles sur notre site web et aux entrées du zoo.
    <br>
    Nous offrons une expérience enrichissante pour les groupes scolaires et les visites en groupe de plus de 5 personnes, avec des <strong> préférentiels et la possibilité d'organiser des visites guidées éducatives sur demande</strong>. Que ce soit pour une sortie scolaire ou une visite en famille élargie, l'Arcadia Zoo est le lieu parfait pour explorer, apprendre et créer des souvenirs ensemble.
    <br>
    Pour les réservations de groupe, veuillez nous contacter <strong>au moins deux semaines à l'avance</strong>. Cela nous permettra de préparer au mieux votre accueil et de personnaliser votre visite selon vos besoins spécifiques. Les demandes peuvent être adressées via notre formulaire de contact sur notre site web ou par téléphone, en mentionnant le nombre de visiteurs, l'âge des participants et toute demande spéciale concernant votre programme de visite.
    <br>
    Nous sommes impatients de vous accueillir à l'Arcadia Zoo et de vous offrir une journée pleine de découvertes et d'amusement. Pour toute question ou demande spécifique, n'hésitez pas à nous <a href="contact.php" class="orange-text">contacter</a>. <strong>Votre aventure commence ici !</strong></p>

    <table class="horaires-tables">
        <thead>
            <tr class="tableau">
                <th>Jour</th>
                <th>Horaires</th>
            </tr>
        </thead>
        <tbody id="horaires-table">
            <?php
            $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');
            // Requête pour récupérer les horaires
            $stmt = $pdo->query("SELECT * FROM horaires_ouverture");
            while ($horaire = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $status = $horaire['ferme'] == 1 ? "Fermé" : "{$horaire['heure_ouverture']} - {$horaire['heure_fermeture']}";
                echo "<tr>
                        <td class='jour-bold'>{$horaire['jour']}</td>
                        <td>{$status}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include 'assets/includes/footer.php'; ?>
    <script src="hamburger.js"></script>

</body>
</html>
