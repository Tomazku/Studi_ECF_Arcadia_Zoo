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
        
        <form method="post" action="login_process.php">
            <label for="email">E-mail :</label>
            <input type="email" id="email" name="email" required><br>
            <label for="motDePasse">Mot de passe :</label>
            <input type="password" id="motDePasse" name="motDePasse" required><br>
            <input type="submit" value="Se connecter">
            <button class="button"><a href="/Studi_ECF_Arcadia_Zoo/index.php">Retour à l'accueil</a></button>
        </form>
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo "<p>Identifiants incorrects.</p>";
        }
        ?>
    </div>
</body>
</html>
