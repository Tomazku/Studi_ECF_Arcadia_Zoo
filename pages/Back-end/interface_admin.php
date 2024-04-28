<?php
require_once('auth.php');

// Fonction pour récupérer les utilisateurs depuis la base de données
function getUtilisateurs() {
    global $pdo;
    $query = "SELECT email, role FROM utilisateurs";
    $statement = $pdo->query($query);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les utilisateurs depuis la base de données
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
    <!-- Menu de navigation vertical fixe -->
    <nav class="sidebar">
        <ul>
            <li><a href="#">Tableau de bord</a></li>
            <li><a href="#">Gestion des utilisateurs</a></li>
            <li><a href="#">Gestion des animaux</a></li>
            <li><a href="./horaires.php">Gestion des horaires</a></li>
            <li><a href="./traitement_avis.php">Gestion des avis</a></li>

            <!-- Ajoutez d'autres liens de navigation ici -->
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
                        <td><?= $utilisateur['email'] ?></td>
                        <td><?= $utilisateur['role'] ?></td>
                        <td>
                            <button class="btn-delete" data-email="<?= $utilisateur['email'] ?>">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </div>

    <!-- Bouton de déconnexion -->
    <form id="logout-form" action="/pages/Back-end/logout.php" method="post">
        <button type="submit" class="btn-logout">Déconnexion</button>
    </form>
</body>
</html>
