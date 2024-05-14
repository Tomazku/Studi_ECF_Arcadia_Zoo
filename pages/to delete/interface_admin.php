<?php
require_once('auth.php');

// Vérifier si l'utilisateur est authentifié et a le rôle 'admin'
check_authentication();
check_role(['admin']);

function getUtilisateurs() {
    global $pdo;
    $query = "SELECT email, role FROM utilisateurs";
    $statement = $pdo->query($query);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

$utilisateurs = getUtilisateurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
    <nav class="sidebar">
        <ul>
            <li><a href="#">Gestion des utilisateurs</a></li>
            <li><a href="#">Gestion des animaux</a></li>
            <li><a href="../Back-end/horaires/horaires.php">Gestion des horaires</a></li>
            <li><a href="../Back-end/avis/administration_avis.php">Gestion des avis</a></li>
        </ul>
    </nav>

    <div class="content">
        <header>
            <h1>Interface d'administration</h1>
        </header>
        <section class="utilisateurs">
            <h2>Utilisateurs existants</h2>
            <table>
                <tr>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($utilisateurs as $utilisateur) : ?>
                    <tr>
                        <td><?= htmlspecialchars($utilisateur['email']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['role']) ?></td>
                        <td>
                            <button class="btn-delete" data-email="<?= htmlspecialchars($utilisateur['email']) ?>">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </div>

    <form id="logout-form" action="logout.php" method="post">
        <button type="submit" class="btn-logout">Déconnexion</button>
    </form>
</body>
</html>
