<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

// Vérification des informations de connexion
if(isset($_POST['mail']) && isset($_POST['motDePasse'])) {
    // Récupération des données saisies
    $email = $_POST['mail'];
    $mot_de_passe = $_POST['motDePasse'];
    
    // Requête pour vérifier les informations d'identification
    $query = "SELECT * FROM administrateurs WHERE email = :email AND motDePasse = :motDePasse";
    $statement = $pdo->prepare($query);
    $statement->execute(array(
        ':mail' => $mail,
        ':motDePasse' => $motDePasse
    ));
    
    // Vérification du résultat de la requête
    $admin = $statement->fetch(PDO::FETCH_ASSOC);
    if($admin) {
        // Connexion réussie, rediriger vers la zone d'administration
        header('Location: interface_admin.php');
        exit();
    } else {
        // Informations d'identification incorrectes, afficher un message d'erreur
        $erreur = "Identifiants incorrects";
    }
}
?>

<!-- Formulaire de connexion -->
<link rel="stylesheet" href="back-end.css">
<form method="post" action="interface_admin.php">
    <label for="email">E-mail :</label>
    <input type="email" id="email" name="email" required><br>
    <label for="mot_de_passe">Mot de passe :</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>
    <input type="submit" value="Se connecter">
</form>

<?php
// Afficher un message d'erreur s'il y en a un
if(isset($erreur)) {
    echo "<p>$erreur</p>";
}
?>
