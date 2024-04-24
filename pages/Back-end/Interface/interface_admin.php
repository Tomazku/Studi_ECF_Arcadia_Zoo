<?php
require_once('auth.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Créer un nouveau compte</h1>
    
    <h2>Employé</h2>
    <form action="creation_employe.php" method="post">
        <label for="employe_email">Courriel :</label>
        <input type="email" id="employe_email" name="employe_email" required>
        
        <label for="employe_password">Mot de passe :</label>
        <input type="password" id="employe_password" name="employe_password" required>
        
        <button type="submit">Créer compte employé</button>
    </form>
    
    <h2>Vétérinaire</h2>
    <form action="create_veterinaire.php" method="post">
        <label for="veterinaire_email">Courriel :</label>
        <input type="email" id="veterinaire_email" name="veterinaire_email" required>
        
        <label for="veterinaire_password">Mot de passe :</label>
        <input type="password" id="veterinaire_password" name="veterinaire_password" required>
        
        <button type="submit">Créer compte vétérinaire</button>
    </form>
</body>
</html>
