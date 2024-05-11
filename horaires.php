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
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            text-align: left;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>

<body>
    <h1 class="horaire-title">Horaires <span class="orange-text"> d'Ouverture</span></h1>
    <table border="1" align="center">
        <thead>
            <tr>
                <th>Jour</th>
                <th>Horaires</th>
            </tr>
        </thead>
        <tbody class="horaires-tables" id="horaires-table">
            <?php
            // Connexion à la base de données
            $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');
            // Requête pour récupérer les horaires
            $stmt = $pdo->query("SELECT * FROM horaires_ouverture");
            while ($horaire = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $status = $horaire['ferme'] == 1 ? "Fermé" : "{$horaire['heure_ouverture']} - {$horaire['heure_fermeture']}";
                echo "<tr>
                        <td>{$horaire['jour']}</td>
                        <td>{$status}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include 'assets/includes/footer.php'; ?>

</body>
</html>
