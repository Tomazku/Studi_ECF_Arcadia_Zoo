<?php
// Connexion à la base de données (à adapter selon vos paramètres)
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Vérification de l'action à effectuer sur l'avis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $avis_id = $_POST['avis_id'];
    $action = $_POST['action'];

    // Traitement de l'avis en fonction de l'action
    if ($action === 'approuver') {
        $query = "UPDATE avis SET isVisible = 1 WHERE avis_id = :avis_id";
        $message = "L'avis a été approuvé avec succès.";
    } elseif ($action === 'rejeter') {
        $query = "DELETE FROM avis WHERE avis_id = :avis_id";
        $message = "L'avis a été rejeté avec succès.";
    }

    // Exécution de la requête
    $statement = $pdo->prepare($query);
    $statement->execute(array(':avis_id' => $avis_id));

    // Redirection vers la page d'administration des avis avec un message de succès
    header('Location: administration_avis.php?success=1');
    exit; // Assurez-vous de terminer le script après la redirection
}

// Récupération des avis en attente de validation
$query_attente = "SELECT * FROM avis WHERE isVisible = 0";
$statement_attente = $pdo->query($query_attente);
$avis_en_attente = $statement_attente->fetchAll(PDO::FETCH_ASSOC);

// Récupération des avis déjà traités
$query_traite = "SELECT * FROM avis WHERE isVisible = 1";
$statement_traite = $pdo->query($query_traite);
$avis_traite = $statement_traite->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des avis</title>
</head>
<body>
    <h1>Administration des avis</h1>

    <?php
    // Affichage du message de succès si l'avis a été soumis avec succès
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<p class='success'>Votre avis a été soumis avec succès et est en attente de validation.</p>";
    }
    ?>

    <!-- Liste des avis en attente de validation -->
    <h2>Avis en attente de validation</h2>
    <ul>
        <?php foreach ($avis_en_attente as $avis) : ?>
            <li>
                <strong><?= $avis['pseudo'] ?>:</strong> <?= $avis['commentaire'] ?>
                <!-- Form pour valider ou rejeter l'avis -->
                <form action="administration_avis.php" method="POST">
                    <input type="hidden" name="avis_id" value="<?= $avis['avis_id'] ?>">
                    <button type="submit" name="action" value="approuver">Approuver</button>
                    <button type="submit" name="action" value="rejeter">Rejeter</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Liste des avis déjà traités -->
    <h2>Liste des avis traités</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Avis</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($avis_traite as $avis) : ?>
                <tr>
                    <td><?= $avis['pseudo'] ?></td>
                    <td><?= $avis['commentaire'] ?></td>
                    <td><?= $avis['isVisible'] ? 'Approuvé' : 'Rejeté' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
