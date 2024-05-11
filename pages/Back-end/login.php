<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Vérification des informations de connexion
if(isset($_POST['email']) && isset($_POST['motDePasse'])) {
    // Récupération des données saisies
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse'];
    
    // Requête pour vérifier les informations d'identification
    $query = "SELECT * FROM utilisateurs WHERE email = :email AND motDePasse = :motDePasse";
    $statement = $pdo->prepare($query);
    $statement->execute(array(
        ':email' => $email,
        ':motDePasse' => $motDePasse
    ));
    
    // Vérification du résultat de la requête
    $admin = $statement->fetch(PDO::FETCH_ASSOC);
    if($admin) {
        // Récupérer le rôle de l'utilisateur à partir de la base de données
        $_SESSION['utilisateur_id'] = $admin['id'];
        
        // Redirection vers l'interface appropriée en fonction du rôle de l'utilisateur
        switch($admin['role']) {
            case 'admin':
                header('Location: interface_admin.php');
                exit();
            case 'veterinaire':
                header('Location: interface_veterinaire.php');
                exit();
            // Ajoutez d'autres cas pour d'autres rôles si nécessaire
            default:
                // Redirection vers une page par défaut si le rôle n'est pas reconnu
                header('Location: interface_employe.php');
                exit();
        }
    } else {
        // Informations d'identification incorrectes, afficher un message d'erreur
        $erreur = "Identifiants incorrects";
    }
}
?>

<!-- Formulaire de connexion -->
<link rel="stylesheet" href="back-end.css">
<div class="container">
<h1 class="connexion">Connexion pour les employés</h1>
<form method="post" action="login.php">
    <label for="email">E-mail :</label>
    <input type="email" id="email" name="email" required><br>
    <label for="motDePasse">Mot de passe :</label>
    <input type="password" id="motDePasse" name="motDePasse" required><br>
    <input type="submit" value="Se connecter">
</form>
</div>

<?php
// Afficher un message d'erreur s'il y en a un
if(isset($erreur)) {
    echo "<p>$erreur</p>";
}
?>
