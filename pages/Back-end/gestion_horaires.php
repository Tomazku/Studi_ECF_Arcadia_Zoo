<?php
include('header.php');

// Vérifiez le rôle
if (!in_array($role, ['admin', 'veterinaire', 'employe'])) {
    header('Location: unauthorized.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Horaires d'Ouverture</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
    <div class="schedule-management-container">
        <h1>Gestion des Horaires d'Ouverture</h1>
        <form class="schedule-form" method="post" action="./update_horaires.php" onsubmit="return confirmUpdate()">
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Heure d'Ouverture</th>
                        <th>Heure de Fermeture</th>
                        <th>Fermé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
include('./pdo.php');
$stmt = $pdo->query("SELECT * FROM horaires_ouverture");
                    while ($horaire = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= htmlspecialchars($horaire['jour']) ?></td>
                            <td><input type="time" name="heure_ouverture[<?= $horaire['horaires_id'] ?>]" value="<?= $horaire['heure_ouverture'] ?>" /></td>
                            <td><input type="time" name="heure_fermeture[<?= $horaire['horaires_id'] ?>]" value="<?= $horaire['heure_fermeture'] ?>" /></td>
                            <td><input type="checkbox" name="ferme[<?= $horaire['horaires_id'] ?>]" <?= $horaire['ferme'] ? "checked" : "" ?> /></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="form-footer">
                <button type="submit">Mettre à jour tous les horaires</button>
            </div>
        </form>
    </div>

    <script>
        function confirmUpdate() {
            return confirm("Êtes-vous sûr de vouloir mettre à jour les horaires?");
        }
    </script>
<?php
include('footer.php');
?>
</body>
</html>
