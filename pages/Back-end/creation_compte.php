<?php
include('header.php');
include('./pdo.php');


$successMessage = '';
$errorMessage = '';

// Traitement du formulaire pour ajouter un nouvel utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $motDePasse = password_hash($_POST['motDePasse'], PASSWORD_BCRYPT); // Hachage du mot de passe
    $role = $_POST['role'];

    // Vérifier si l'utilisateur existe déjà
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM utilisateurs WHERE email = ?');
    $stmt->execute([$email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $errorMessage = 'Erreur : cet email est déjà utilisé !';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO utilisateurs (email, motDePasse, role) VALUES (?, ?, ?)');
            $stmt->execute([$email, $motDePasse, $role]);
            $successMessage = 'Utilisateur ajouté avec succès !';
        } catch (PDOException $e) {
            $errorMessage = 'Erreur : ' . $e->getMessage();
        }
    }
}

// Suppression de l'utilisateur
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM utilisateurs WHERE utilisateur_id = ?');
    $stmt->execute([$id]);

    // Redirection après suppression
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Récupération des utilisateurs existants
$stmt = $pdo->query('SELECT utilisateur_id, email, role FROM utilisateurs');
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
    <header class="creation_compte_header">
        <div class="nouveaux_comptes">
            <h1>Créer un nouveau compte</h1>
            <form id="creation-form" action="" method="post">
                <label for="email">Courriel :</label>
                <input type="email" id="email" name="email" required>
                
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="motDePasse" name="motDePasse" required>

                <label for="role">Rôle :</label>
                <select id="role" name="role" required>
                    <option value="employe">Employé</option>
                    <option value="veterinaire">Vétérinaire</option>
                </select>

                <button type="submit">Créer compte</button>
            </form>
            <?php if ($successMessage): ?>
                <p class="success-message"><?= htmlspecialchars($successMessage); ?></p>
            <?php endif; ?>
            <?php if ($errorMessage): ?>
                <p class="error-message"><?= htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>
        </div>
    </header>

    <section class="utilisateurs-ajoutes">
        <h2>Utilisateurs ajoutés</h2>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                    <td><?= htmlspecialchars($utilisateur['email']); ?></td>
                    <td><?= htmlspecialchars($utilisateur['role']); ?></td>
                    <td>
                        <a href="?delete=<?= $utilisateur['utilisateur_id']; ?>" class="supprimer-btn">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

<?php
include('footer.php');
?>
</body>
</html>
