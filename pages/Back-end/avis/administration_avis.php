<?php
include('../header.php');
include('pdo.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $avis_id = $_POST['avis_id'];
    $action = $_POST['action'];

    if ($action === 'approuver') {
        $query = "UPDATE avis SET isVisible = 1 WHERE avis_id = :avis_id";
        $message = "L'avis a été approuvé avec succès.";
    } elseif ($action === 'rejeter') {
        $query = "DELETE FROM avis WHERE avis_id = :avis_id";
        $message = "L'avis a été rejeté avec succès.";
    }

    $statement = $pdo->prepare($query);
    $statement->execute(array(':avis_id' => $avis_id));

    header('Location: administration_avis.php?success=1');
    exit; 
}

$query_attente = "SELECT * FROM avis WHERE isVisible = 0";
$statement_attente = $pdo->query($query_attente);
$avis_en_attente = $statement_attente->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="../interfaces.css">
</head>
<body>
    <div class="review-management-container">
        <h1>Administration des avis</h1>

        <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<p class='success-message'>L'action sur l'avis a été effectuée avec succès.</p>";
        }
        ?>

        <h2>Avis en attente de validation</h2>
        <ul class="pending-reviews">
            <?php foreach ($avis_en_attente as $avis) : ?>
                <li class="review-item">
                    <strong><?= htmlspecialchars($avis['pseudo']) ?>:</strong> <?= htmlspecialchars($avis['commentaire']) ?>
                    <form class="review-action-form" action="administration_avis.php" method="POST">
                        <input type="hidden" name="avis_id" value="<?= $avis['avis_id'] ?>">
                        <button type="submit" name="action" value="approuver" class="approve-btn">Approuver</button>
                        <button type="submit" name="action" value="rejeter" class="reject-btn">Rejeter</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>Liste des avis traités</h2>
        <table class="review-table">
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
                        <td><?= htmlspecialchars($avis['pseudo']) ?></td>
                        <td><?= htmlspecialchars($avis['commentaire']) ?></td>
                        <td><?= $avis['isVisible'] ? 'Approuvé' : 'Rejeté' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include('../footer.php'); ?>
</body>
</html>
