<?php
include('header.php');

// Récupérer le rôle de l'utilisateur
$role = getUserRole();

// Récupérer les données nécessaires en fonction du rôle
function getDashboardData($pdo) {
    $data = [];
    // Récupérer le nombre d'animaux
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM animal");
    $data['animal_count'] = $stmt->fetchColumn();

    // Récupérer le nombre d'avis en attente
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM avis WHERE isVisible = 0");
    $data['avis_pending_count'] = $stmt->fetchColumn();

    // Récupérer le nombre de messages de contact
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM messages");
    $data['contact_count'] = $stmt->fetchColumn();

    // Récupérer le nombre d'utilisateurs
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM utilisateurs");
    $data['user_count'] = $stmt->fetchColumn();

    // Récupérer les horaires
    $stmt = $pdo->query("SELECT jour, heure_ouverture, heure_fermeture, ferme FROM horaires_ouverture");
    $data['horaires'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les utilisateurs
    $stmt = $pdo->query("SELECT email, role FROM utilisateurs");
    $data['users'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

$data = getDashboardData($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Tableau de Bord</h1>
        <div class="dashboard-summary">
            <div class="dashboard-card">
                <h2>Animaux</h2>
                <p>Nombre total : <?= htmlspecialchars($data['animal_count']); ?></p>
                <button onclick="window.location.href='animals/animal.php'">Voir plus</button>
            </div>
            <?php if ($role === 'admin'): ?>
            <div class="dashboard-card">
                <h2>Utilisateurs</h2>
                <p>Nombre total : <?= htmlspecialchars($data['user_count']); ?></p>
                <button onclick="window.location.href='creation_compte.php'">Voir plus</button>
            </div>
            <?php endif; ?>
            <div class="dashboard-card">
                <h2>Habitats</h2>
                <button onclick="window.location.href='animals/habitats.php'">Voir plus</button>
            </div>
            <div class="dashboard-card">
                <h2>Avis</h2>
                <p>En attente : <?= htmlspecialchars($data['avis_pending_count']); ?></p>
                <button onclick="window.location.href='avis/administration_avis.php'">Voir plus</button>
            </div>
            <div class="dashboard-card">
                <h2>Contact</h2>
                <p>Messages reçus : <?= htmlspecialchars($data['contact_count']); ?></p>
                <button onclick="window.location.href='contact_BG.php'">Voir plus</button>
            </div>
            <div class="dashboard-card">
                <h2>Services</h2>
                <button onclick="window.location.href='gestion_services.php'">Voir plus</button>
            </div>
            <div class="dashboard-card">
                <h2>Horaires</h2>
                <button onclick="window.location.href='gestion_horaires.php'">Voir plus</button>
            </div>
        </div>
        <div class="dashboard-details">
            <h2>Horaires d'Ouverture</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Ouverture</th>
                        <th>Fermeture</th>
                        <th>Fermé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['horaires'] as $horaire): ?>
                        <tr>
                            <td><?= htmlspecialchars($horaire['jour']); ?></td>
                            <td><?= htmlspecialchars($horaire['heure_ouverture']); ?></td>
                            <td><?= htmlspecialchars($horaire['heure_fermeture']); ?></td>
                            <td><?= $horaire['ferme'] ? 'Oui' : 'Non'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if ($role === 'admin'): ?>
        <div class="dashboard-details">
            <h2>Utilisateurs</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['users'] as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><?= htmlspecialchars($user['role']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
