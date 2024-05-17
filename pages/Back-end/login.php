<?php
session_start();
require_once('auth.php');

$erreur = '';

if (isset($_POST['email']) && isset($_POST['motDePasse'])) {
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse'];
    
    $utilisateur = authenticate($email, $motDePasse);
    
    if ($utilisateur) {
        $_SESSION['utilisateur_id'] = $utilisateur['utilisateur_id'];
        
        switch ($utilisateur['role']) {
            case 'admin':
                header('Location: admin_dashboard.php');
                exit();
            case 'veterinaire':
                header('Location: veterinarian_dashboard.php');
                exit();
            default:
                header('Location: employee_dashboard.php');
                exit();
        }
    } else {
        $erreur = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
    <div class="container-connexion">
        <h1 class="connexion">Connexion pour les employés</h1>
        <form method="post" action="login.php">
            <label for="email">E-mail :</label>
            <input type="email" id="email" name="email" required><br>
            <label for="motDePasse">Mot de passe :</label>
            <input type="password" id="motDePasse" name="motDePasse" required><br>
            <input type="submit" value="Se connecter">
        </form>
        <button><a href="/index.php" class="button">Retour à l'accueil</a></button>
        <?php
        if (!empty($erreur)) {
            echo "<p>$erreur</p>";
        }
        ?>
    </div>
</body>
</html>
