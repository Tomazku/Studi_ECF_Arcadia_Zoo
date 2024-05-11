<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Horaires d'Ouverture</title>
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
        button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Gestion des Horaires d'Ouverture</h1>
    <form method="post" action="./update_horaires.php" onsubmit="return confirmUpdate()">
        <table border="1" align="center">
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
                $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');
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
        <div style="text-align: center;">
            <button type="submit">Mettre à jour tous les horaires</button>
        </div>
    </form>

    <script>
        function confirmUpdate() {
            return confirm("Êtes-vous sûr de vouloir mettre à jour les horaires?");
        }
    </script>
</body>
</html>
