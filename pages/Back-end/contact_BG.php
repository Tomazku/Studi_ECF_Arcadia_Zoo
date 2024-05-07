<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des messages - Arcadia Zoo</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
</head>
<body>

<h1>Gestion des messages - Arcadia Zoo</h1>

<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification de la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Utilisez FILTER_SANITIZE_SPECIAL_CHARS pour nettoyer les entrées
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($nom && $prenom && $email && $message) {
        try {
            // Préparez et exécutez l'insertion SQL
            $sql = "INSERT INTO messages (nom, prenom, email, messages) VALUES (:nom, :prenom, :email, :messages)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':messages', $message);
            $stmt->execute();
            echo "<h2>Merci ! Votre message a été envoyé.</h2>";
        } catch (PDOException $e) {
            http_response_code(500);
            echo "Erreur lors de l'envoi du message : " . $e->getMessage();
        }
    } else {
        http_response_code(400);
        echo "Veuillez vérifier les champs du formulaire.";
    }
}

// Affichage des messages
try {
    $sql = "SELECT nom, prenom, email, messages FROM messages";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $messages = $stmt->fetchAll();

    // Affichez les messages de manière sécurisée
    foreach ($messages as $msg) {
        echo "<p>Nom: " . htmlspecialchars($msg['nom']) . ", Prénom: " . htmlspecialchars($msg['prenom']) . ", Email: " . htmlspecialchars($msg['email']) . ", Message: " . htmlspecialchars($msg['messages']) . "</p>";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
