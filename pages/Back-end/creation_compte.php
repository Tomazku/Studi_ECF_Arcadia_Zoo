<?php
require_once('auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement de la création de compte ici
    // Assurez-vous d'ajouter la logique appropriée pour créer un nouveau compte
    // Une fois le compte créé avec succès, vous pouvez rediriger l'utilisateur vers une autre page ou afficher un message de succès
    // Par exemple, vous pouvez utiliser header('Location: interface_admin.php'); pour rediriger l'utilisateur
    // Ou vous pouvez afficher un message de succès et un lien pour revenir à l'interface admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
    <header>
        <h1>Créer un nouveau compte</h1>
        <form id="creation-form" action="creation_compte.php" method="post">
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
    </header>
</body>
</html>
